(function () {
    window.addEventListener('load', function () {

        var $replys = $('.comment-list .comment-reply-link');
        var selectedReplay = null;
        $replys.each(function (index) {
            $(this).on('click', function () {
                $comment_id = $(this).closest('.comment-body').find('.comment_id').text().trim();
                if (selectedReplay == null) {
                    selectedReplay = $(this).closest('.comment-body').find('.comment-meta');
                    selectedReplay.addClass('border-primary-rounded');
                } else if (selectedReplay[0] == $(this).closest('.comment-body').find('.comment-meta')[0]) {
                    selectedReplay.removeClass('border-primary-rounded');
                    selectedReplay = null;
                } else {
                    selectedReplay.removeClass('border-primary-rounded');
                    selectedReplay = $(this).closest('.comment-body').find('.comment-meta');
                    selectedReplay.addClass('border-primary-rounded');
                }
                if (selectedReplay != null) {
                    $('#commentform .comment_id').val($comment_id);
                } else {
                    $('#commentform .comment_id').val('');
                }
            });
        });

        var $buttonMores = $('.btn-more-comments');
        $buttonMores.each(function (index) {
            $(this).on('click', function () {
                var $but = $(this);
                var comment_id = $(this).closest('.comment-body').find('.comment_id').text().trim();
                //console.log(comment_id);
                $.ajax({
                    url: '/ajax/getcomments',
                    data: {'comment_id': comment_id}
                }).done(function (response) {
                    if (response.length > 4) {
                        var comments = JSON.parse(response);
                        $but.closest('.comment-body').after(getSubCommentsBlock(comments));
                    }
                    $but.remove();
                });
            });
        });

        var getSubCommentsBlock = function (data) {
            var content = '<ol class="children">';
            for (var i = 0; i < data.length; i++) {
                content +=
                    '<li class="comment byuser odd alt depth-2 parent">' +
                    '<article class="comment-body">' +
                    '<footer class="comment-meta">' +
                    '<div class="comment-author vcard">' +
                    '<a class="author_url" rel="external nofollow" href="mailto:' + data[i].email + '">' + data[i].login + '</a>' +
                    '</div>' +
                    '<div class="comment-metadata"> ' +
                    '<span>' + data[i].date + '</span>' +
                    '</div>' +
                    '</footer>' +
                    '<div class="comment-content">' +
                    '<p>' + data[i].comment + '</p>' +
                    '</div>' +
                    '</article>' +
                    '</li>'
            }
            content += '</ol>';

            return content;
        }

        var $sendMessageForm = $('#commentform');
        var $sendMessageButton = $('#commentform #submit');
        $sendMessageButton.on('click', function () {
            var message = {
                author: '',
                email: '',
                comment: '',
                comment_id: '',
                post_id: '',
                x1: '',
                x2: ''
            }
            //валидация!!!!!
            message.author = $sendMessageForm.find('#author').val();
            message.email = $sendMessageForm.find('#email').val();
            message.comment = $sendMessageForm.find('#comment').val();
            message.comment_id = $sendMessageForm.find('#comment_id').val();
            message.post_id = $sendMessageForm.find('#post_id').val();
            message.x1 = $sendMessageForm.find('#x1').val();// находит input hidden по id = x1
            message.x2 = $sendMessageForm.find('#x2').val();// находит input hidden по id = x2
            message.captcha = $sendMessageForm.find('#captcha').val();// находит input по id = captcha


            console.dir(message);



            // my code
            var errorMessage = "";
            var is_correct_author = /^[A-z0-9]{5,15}$/.test(message.author);//name
            if(!is_correct_author){   // заходит в if, если is_correct_author = false
                $header = $('.comment-form-author'); // место на html где показывать сообщение
                errorMessage = "Login must be from 5 to 15 characters and contain only letters and digits";
                $header.append(showReportDialog(errorMessage, 'alert-danger'));
            }


            // alert( "A\nB".match(/A.B/s) );
            var is_correct_comment = /^.{2,100}$/s.test(message.comment);//comment
            if(!is_correct_comment){
                $header = $('.comment-form-comment');
                errorMessage = "Comments must be less than 100 and greater than 1";
                $header.append(showReportDialog(errorMessage, 'alert-danger'));
            }

            var is_correct_captcha = true;
            if(message.x1 + message.x2 != message.captcha){
                is_correct_captcha = false;
                $header = $('.comment-form-captcha');
                errorMessage = "Error in Captcha";
                $header.append(showReportDialog(errorMessage, 'alert-danger'));

            }

            //   логическое сложение =  or = |
            //   логическое умножение  = and = &
            // 1+0=1; 0+1=1; 0+0=0; 1+1=1;
            // 1*0=0; 0*1=0; 0*0=0; 1*1=1;
            // 1 = true
            // 0 = false

            // is_correct_captcha = true = 1
            // is_correct_author == true = 1
            // is_correct_comment == true = 1


            if(!is_correct_captcha || !is_correct_author || !is_correct_comment){   //  0 + 0 + 0 = 0
                return;
            }

            // if(is_correct_captcha && is_correct_author && is_correct_comment){   //  1 * 1 * 1 = 1
            //     // console.log("ok")
            // }
            // else{
            //     return;
            // }
            //
            //
            // if(! (is_correct_captcha && is_correct_author && is_correct_comment)){   //  1 * 1 * 1 = 1
            //     return;
            // }



            // if(message.author.length > 20){
            //     $header = $('.comment-form-author');
            //     var errorMessage = "Login must be less than 20 ";
            //     $header.append(showReportDialog(errorMessage, 'alert-danger'));
            // }
            // end my code


            $.ajax({
                url: '/ajax/savecomment',
                data: message,
                method: "POST"
            }).done(function (response) {
                console.log(response);
                $header = $('.comment-reply-title');
                var contentMessage = '';
                if (response.includes("ADDED")) {
                    contentMessage = "Message sent successfully";
                    $header.append(showReportDialog(contentMessage, 'alert-success'));
                    
                }
                if (response.includes("ERROR")) {
                    contentMessage = "ERROR";
                    $header.append(showReportDialog(contentMessage));
                }

                if (response.includes("CAPTCHA")) {
                    contentMessage = "Error in Captcha";
                    $header.append(showReportDialog(contentMessage));
                }

                $sendMessageForm.trigger("reset");
            });
        });

        var showReportDialog = function (message, classMode = 'alert-danger') {
            //alert-danger
            //alert-success
            return '<div class="alert ' + classMode + ' alert-dismissible show" role="alert">\n' +
                '  <strong>' + message + '!</strong>' +
                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '    <span aria-hidden="true">&times;</span>\n' +
                '  </button>\n' +
                '</div>';
        }
    })
})()