<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerZUmlnMG\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerZUmlnMG/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerZUmlnMG.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerZUmlnMG\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerZUmlnMG\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'ZUmlnMG',
    'container.build_id' => 'e00e7933',
    'container.build_time' => 1584483495,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerZUmlnMG');
