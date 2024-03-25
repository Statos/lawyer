<?php

use app\modules\comments\models\Comments;

/** @var $models Comments[] */
/** @var $options array */

?>


<div class="scroll c-tAll">
    <?php
    if (isset($models))
        foreach ($models as $comment) : ?>

            <div class="comment c-t<?= $comment->ctype ?> <?php if (false && $comment->state == 0): ?> comment-not-approved <?php endif; ?>"
                 comment_id="<?= $comment->id ?>">
                <div class="c-avatar" rel="<?php echo $comment->author ? $comment->author->id : ""; ?>"
                     style="background-image: url(<?php echo $comment->author ? $comment->getAuthorPhoto() : ""; ?>)"></div>
                <div class="comment-info row">
                    <div class="col-md-9">
                        <div class="row c-user"><?= $comment->getLogin() ?></div>
                        <div class="row c-txt"><?= $comment->txt ?></div>

                        <div class="row c-attach">
                            <?php foreach ($comment->getAttach() as $attach): ?>
                                <?php if ($attach->typeImages()): ?>
                                    <a class="fancybox ajax" rel="gallery_id-<?= $comment->id ?>"
                                       href="<?= $attach->getUrl() ?>" onclick="fancyBox(this);return false;">
                                        <div class="col-md-3">
                                            <img src="<?= $attach->getThumbUrl() ?>">
                                        </div>
                                    </a>
                                <?php elseif ($attach->typeDocuments()): ?>
                                    <a class="noajax" href="<?= $attach->getUrl() ?>">
                                        <div class="col-md-3">
                                            <img src="/images/text-file-icon.png" width=64/>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="c-date"><?= $comment->getDate() ?></div>

                        <?php if (!empty($options['answers']) || !Yii::$app->user->isGuest): //TODO?>
                            <span class="answer-activate no-main btn">Ответить</span>

                        <?php endif; ?>
                    </div>
                    <!-- <div class="c-like"><span>{{ comment.likes }}</span></div> -->
                </div>
                <div class="c-responce">
                    <?php if ($comment->children): ?>
                        <div class="answers">
                            <?php echo $this->render('_index_item', ['models' => $comment->children, 'options' => $options]); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div style="clear:both;"></div>
            </div>
        <?php endforeach; ?>
</div>