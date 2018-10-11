<div class="box-body">


    <?php if (config('asgard.page.config.partials.translatable.create') !== []): ?>
    <?php foreach (config('asgard.page.config.partials.translatable.create') as $partial): ?>
    @include($partial)
    <?php endforeach; ?>
    <?php endif; ?>



</div>
