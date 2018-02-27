<ul class="pagination">
    <?php if($currentpage > 1): ?>
        <li class="pagination__item pagination__item--previous"><a href="<?php echo e(getURL()); ?>?p=<?php echo e($currentpage - 1); ?>" class="pagination__item-link">Previous</a></li>
    <?php endif; ?>
    <?php for($i = 1; $i <= $numberofpages; $i++): ?>
        <li class="pagination__item <?php echo e($i == $currentpage ? 'active' : ''); ?>"><a href="<?php echo e(getURL()); ?>?p=<?php echo e($i); ?>" class="pagination__item-link"><?php echo e($i); ?></a></li>
    <?php endfor; ?>
    <?php if($currentpage < $numberofpages): ?>
        <li class="pagination__item pagination__item--next"><a href="<?php echo e(getURL()); ?>?p=<?php echo e($currentpage + 1); ?>" class="pagination__item-link">Next</a></li>
    <?php endif; ?>
</ul>