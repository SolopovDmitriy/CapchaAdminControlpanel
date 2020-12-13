<?php
if (!isset($data['post'])) {
    return;
}
$onePost = $data['post'];
?>
<section id="middle" class="light_section">
    <div class="container">
        <div class="row blog-single">
            <div class="col-sm-12">
                <div class="content-area" id="primary">
                    <div role="main" class="site-content" id="content" >
                        <article class="post type-post">
                            <header class="entry-header">
                                <div class="badgeBox">
                                    <div class="badge">
                                        8
                                        <span>apr</span>
                                    </div>
                                    <div class="extra-wrap text-center">
                                        <a class="tl " href="#"><?= $onePost['title'] ?></a>
                                    </div>
                                </div>
                                <!-- .entry-meta -->
                            </header>
                            <div class="entry-thumbnail">
                                <img alt="<?= $onePost['img_alt'] ?>" src="<?= $onePost['img_src'] ?>">
                            </div>
                            <!-- .entry-header -->

                            <div class="entry-content">
                                <blockquote><?= $onePost['slogan'] ?></blockquote>
                                <div class="content">
                                    <?= $onePost['content'] ?>
                                </div>
                            </div>
                            <br>
                            <!-- .entry-content -->
                            <!-- .entry-meta -->
                        </article>
                        <!-- #post -->

                        <div class="comments-area" id="comments">
                            <h2 class="comments-title">Comments: </h2>
                            <ol class="comment-list">
                                <?php
                                if (!empty($data['comments'])) {
                                    foreach ($data['comments'] as $key => $comment) {
                                        ?>
                                        <li class="comment byuser odd alt thread-odd thread-alt depth-1">
                                            <article class="comment-body">
                                                <div class="hidden comment_id">
                                                    <?= $comment['id'] ?>
                                                </div>
                                                <footer class="comment-meta">
                                                    <div class="comment-author vcard">
                                                        <a class="author_url" rel="external nofollow" href="#">
                                                            <?= $comment['login'] ?>
                                                        </a>
                                                    </div>
                                                    <div class="comment-metadata">
                                                        <span><?= $comment['date'] ?></span>
                                                    </div>
                                                    <div class="reply"><a href="#reply-title"
                                                                          class="comment-reply-link">Reply</a>
                                                    </div>
                                                </footer>
                                                <div class="comment-content">
                                                    <p><?= $comment['comment'] ?></p>
                                                </div>
                                                <input type="button" value="+" class="btn btn-info btn-more-comments">
                                            </article>

                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ol>
                            <!-- .comment-list -->
                            <hr style="margin-bottom: 160px;" class="anchor" id="reply-title">

                            <div class="comment-respond" id="respond">
                                <h3 class="comment-reply-title">Leave a Comment</h3>
                                <form class="comment-form" id="commentform">
                                    <p class="comment-form-author">
                                        <label for="author">Name <span class="required">*</span></label>
                                        <input type="text" aria-required="true" size="30" value="" name="author"
                                               id="author" class="form-control" placeholder="Name">
                                    </p>
                                    <input type="hidden" name="comment_id" value="" id="comment_id" class="comment_id">
                                    <input type="hidden" name="post_id" value="<?= $onePost['id'] ?>" id="post_id" class="post_id">
                                    <p class="comment-form-email">
                                        <label for="email">Email <span class="required">*</span></label>
                                        <input type="email" aria-required="true" size="30" value="" name="email"
                                               id="email" class="form-control" placeholder="Enter email">
                                    </p>
                                    <p class="comment-form-comment">
                                        <label for="comment">Comment</label>
                                        <textarea aria-required="true" rows="8" cols="45" name="comment" id="comment"
                                                  class="form-control" placeholder="Comment"></textarea>
                                    </p>



                                    <p class="comment-form-captcha">
                                        <label for="captcha">captcha <span class="required">*</span></label>
                                        Solve an arithmetic problem: <?=$data['captcha'][0] . "+". $data['captcha'][1] . "="?>
                                        <input type="text" aria-required="true" size="30" value="" name="captcha"        <?php  // input для ответа   на арифметическую задачу ?>
                                               id="captcha" class="form-control" placeholder="">
                                    </p>
                                    <input type="hidden" name="x1" value="<?=$data['captcha'][0]?>" id="x1" >
                                    <input type="hidden" name="x2" value="<?=$data['captcha'][1]?>" id="x2" >
                                    
                                    
                                    <p class="form-submit">
                                        <input type="button" value="Send SMS" id="submit" name="submit"
                                               class="theme_btn">
                                    </p>
                                </form>

                                <?php
                                //print_r($data);
                                /*// это массив в Controllers = content,  а  data в onepost - view
                                Array (
                                        [error] =>

                                        [success] =>

                                        [post] => Array (
                                                [id] => 1
                                                [title] => Шкварки по-английски к пиву
                                                [slogan] => К пиву нужно подавать не креветки или сухарики, как в России, а свиные шкварки и картофельные чипсы.
                                                [img_src] => /static/img/posts/post_1.jpg
                                               [img_alt] => шкварки
                                                [content] => Наверное смысл такой жирной закуски, чтобы меньше хмелеть и не стремиться уйти из паба поужинать.
                                                    Рецепт этих шкварок (Pork scratchings) прост. Но есть и небольшие ухищрения, чтобы шкварки выглядели эстетичней.
                                                     Даже мишленовские повара Британии имеют в своих коллекциях рецепты этих шкварок. Блюдо старинное, интересное,
                                                     но после него, если плохая духовка, кухня будет в дыму и придется протирать духовку. Не полезно, но с пивом
                                                     эти шкварки хороши! Хранить можно пару дней в закрытом контейнере, так что можно брать с собой на пикники. А и
                                                     з растопленного жира можно сделать ароматизированный жир для готовки.
                                                 [date_published] => 2020-11-26 19:00:18
                                                 [date_created] => 2020-11-26 19:00:21
                                                 [status_id] => 2
                                                 [category_id] => 1
                                         )
                                         [comments] => Array (
                                                 [0] => Array (
                                                         [id] => 79 [post_id] => 1 [comment] => dsg [login] => sd [email] => a@gmail [comment_id] => [date] => 2020-12-13 18:00:26 )
                                                         [1] => Array ( [id] => 78 [post_id] => 1 [comment] => a [login] => q [email] => ghr@com [comment_id] => [date] => 2020-12-13 17:57:03 )
                                                         [2] => Array ( [id] => 77 [post_id] => 1 [comment] => a [login] => a [email] => ghr@com [comment_id] => [date] => 2020-12-13 17:35:47 )
                                                         [3] => Array ( [id] => 76 [post_id] => 1 [comment] => pmo [login] => g [email] => nina@com [comment_id] => [date] => 2020-12-13 17:17:18 )
                                                         [4] => Array ( [id] => 74 [post_id] => 1 [comment] => a [login] => a [email] => ghr@com [comment_id] => [date] => 2020-12-13 16:49:24 )
                                                         [5] => Array ( [id] => 73 [post_id] => 1 [comment] => a [login] => g [email] => ghr@com [comment_id] => [date] => 2020-12-13 16:36:56 )
                                                         [6] => Array ( [id] => 72 [post_id] => 1 [comment] => a [login] => q [email] => vmtp@com [comment_id] => [date] => 2020-12-13 16:36:01 )
                                                         [7] => Array ( [id] => 71 [post_id] => 1 [comment] => a [login] => q [email] => vmtp@com [comment_id] => [date] => 2020-12-13 16:36:00 )
                                                          [8] => Array ( [id] => 70 [post_id] => 1 [comment] => a [login] => q [email] => vmtp@com [comment_id] => [date] => 2020-12-13 16:35:58 )
                                                          [9] => Array ( [id] => 68 [post_id] => 1 [comment] => a [login] => d [email] => gtg@com [comment_id] => [date] => 2020-12-13 16:34:03 )
                                            )
                                        [captcha] => Array ( [0] => 46 [1] => 100 ) )

                                */

                                ?>


                            </div>
                            <!-- #respond -->
                            <script src="/static/js/comment.js"></script>
                        </div>
                        <!-- #comments -->

                    </div>
                    <!-- #content -->
                </div>

            </div>
        </div>
    </div>
</section>