<?php $__env->startSection('title', 'Admin Settings'); ?>
<?php $__env->startSection('content-title', $lang['Change Settings']); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.partials.secondary-navigation'); ?>
    <?php $__env->slot('right'); ?>
        <a href="#" class="button-primary"><?php echo e($lang['Save']); ?></a>
    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div id="content">
<div class="container">
    <form action="">
        <div class="row">
            <div class="col-7">
                <div class="admin-box">
                    <h3 class="admin-box__title">Allgemeine Einstellungen</h3>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="title">Titel der Seite</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. PP IT-Systeme" name="settings[title]" id="title" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="subtitle">Untertitel</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. Das ist schön" name="settings[subtitle]" id="subtitle" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="url">Website URL</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. https://pp-systeme.de" name="settings[url]" id="url" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="language">Sprache der Website</label>
                        </div>
                        <div class="col-8">
                            <select name="settings[language]" id="language" class="form-input">
                                <?php $__currentLoopData = $allLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($language['shortName']); ?>" <?php echo e($curLang === $language['shortName'] ? 'selected' : ''); ?>><?php echo e($language['longName']); ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="admin-box">
                    <h3 class="admin-box__title">Mail Einstellungen</h3>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="emailsender">E-Mail Sender</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. mail@mail.de" name="settings[emailsender]" id="emailsender" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="emailreveicer">E-Mail Empfänger</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. mail@mail.de" name="settings[emailreveicer]" id="emailreveicer" class="form-input">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.partials.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>