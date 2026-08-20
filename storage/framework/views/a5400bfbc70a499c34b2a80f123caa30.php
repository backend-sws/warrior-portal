<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'breadcrumbs' => [], 'image' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title', 'breadcrumbs' => [], 'image' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="relative pt-12 pb-12 lg:pt-24 lg:pb-24 px-6 lg:px-[5%] <?php echo e($image ? 'bg-[#040e2d]' : 'bg-gradient-to-r from-[#040e2d] via-[#129aef] to-[#040e2d]'); ?> border-t border-white/10 overflow-hidden flex flex-col items-center justify-center text-center">
    <?php if($image): ?>
        <div class="absolute inset-0 bg-cover bg-center opacity-30 z-0" style="background-image: url('<?php echo e($image); ?>');"></div>
    <?php endif; ?>
    
    <!-- Decorative Elements (Animated) -->
    <div class="absolute top-1/4 left-1/4 w-20 h-20 rounded-full border-[6px] border-white/10 z-0 animate-float-slow"></div>
    <div class="absolute top-1/3 right-1/4 w-32 h-32 opacity-10 z-0 animate-float" style="background-image: radial-gradient(#ffffff 2px, transparent 2px); background-size: 16px 16px;"></div>
    <div class="absolute bottom-1/4 right-1/3 w-40 h-40 bg-blue-400/20 rounded-full blur-3xl z-0 animate-pulse-soft"></div>

    <!-- Content -->
    <div class="relative z-10 w-full mb-2">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 drop-shadow-md"><?php echo e($title); ?></h1>
        
        <div class="flex items-center justify-center gap-2 text-sm font-semibold tracking-wider uppercase">
            <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!$loop->last || $url): ?>
                    <a href="<?php echo e($url); ?>" class="text-blue-200 hover:text-white transition-colors"><?php echo e($label); ?></a>
                    <span class="text-white/50">/</span>
                <?php else: ?>
                    <span class="text-white/90"><?php echo e($label); ?></span>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php /**PATH D:\warrior-portal\resources\views/components/page-header.blade.php ENDPATH**/ ?>