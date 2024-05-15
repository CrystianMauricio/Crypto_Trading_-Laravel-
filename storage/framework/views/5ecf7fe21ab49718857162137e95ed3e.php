<div id="header" class="ui container">
    <div class="ui equal width middle aligned grid">
        <div id="menu-top-bar" class="row">
            <div class="mobile only column">
                <!-- Mobile menu -->
                <div class="ui vertical icon <?php echo e($inverted); ?> menu">
                    <div class="ui left pointing dropdown icon item">
                        <i class="bars icon"></i>
                        <div class="ui stackable large menu">
                            <a href="<?php echo e(route('frontend.dashboard')); ?>" class="item <?php echo e(Route::currentRouteName()=='frontend.dashboard' ? 'active' : ''); ?>">
                                <i class="home icon"></i>
                                <?php echo e(__('app.dashboard')); ?>

                            </a>
                            <a href="<?php echo e(route('frontend.competitions.index')); ?>" class="item <?php echo e(strpos(Route::currentRouteName(),'frontend.competitions.')!==FALSE ? 'active' : ''); ?>">
                                <i class="trophy icon"></i>
                                <?php echo e(__('app.competitions')); ?>

                            </a>
                            <a href="<?php echo e(route('frontend.assets.index')); ?>" class="item <?php echo e(Route::currentRouteName()=='frontend.assets.index' ? 'active' : ''); ?>">
                                <i class="bitcoin icon"></i>
                                <?php echo e(__('app.coins')); ?>

                            </a>
                            <a href="<?php echo e(route('frontend.rankings')); ?>" class="item <?php echo e(Route::currentRouteName()=='frontend.rankings' ? 'active' : ''); ?>">
                                <i class="star icon"></i>
                                <?php echo e(__('app.rankings')); ?>

                            </a>
                            <?php if(config('broadcasting.connections.pusher.key')): ?>
                                <a href="<?php echo e(route('frontend.chat.index')); ?>" class="item <?php echo e(Route::currentRouteName()=='frontend.chat.index' ? 'active' : ''); ?>">
                                    <i class="comments outline icon"></i>
                                    <?php echo e(__('app.chat')); ?>

                                </a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('frontend.help')); ?>" class="item <?php echo e(Route::currentRouteName()=='frontend.help' ? 'active' : ''); ?>">
                                <i class="question icon"></i>
                                <?php echo e(__('app.help')); ?>

                            </a>
                            <?php if(auth()->check()): ?>
                                <div class="item">
                                    <div class="text">
                                        <img class="ui avatar image" src="<?php echo e(auth()->user()->avatar_url); ?>">
                                        <?php echo e(auth()->user()->name); ?>

                                    </div>
                                    <div class="menu">
                                        <?php if(auth()->user()->admin()): ?>
                                            <a href="<?php echo e(route('backend.dashboard')); ?>" class="item">
                                                <i class="setting icon"></i>
                                                <?php echo e(__('app.backend')); ?>

                                            </a>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('frontend.users.show', auth()->user())); ?>" class="item">
                                            <i class="user icon"></i>
                                            <?php echo e(__('users.profile')); ?>

                                        </a>

                                        

                                        <log-out-button token="<?php echo e(csrf_token()); ?>" class="item">
                                            <i class="sign out alternate icon"></i>
                                            <?php echo e(__('auth.logout')); ?>

                                        </log-out-button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- END Mobile menu -->
            </div>
            <div class="tablet only computer only column">
                <h4>
                    <a href="<?php echo e(route('frontend.index')); ?>">
                        <img src="<?php echo e(asset('images/logo.png')); ?>" class="ui image">
                        <?php echo e(__('app.app_name')); ?>

                    </a>
                </h4>
            </div>
            <div class="right aligned column">
                <locale-select :locales="<?php echo e(json_encode($locale->locales())); ?>" :locale="<?php echo e(json_encode($locale->locale())); ?>"></locale-select>
            </div>
        </div>
        <div class="row">
            <div class="tablet only computer only column">
                <!-- Desktop menu -->
                <div class="ui stackable <?php echo e($inverted); ?> menu">
                    <a href="<?php echo e(route('frontend.dashboard')); ?>" class="item <?php echo e(Route::currentRouteName()=='frontend.dashboard' ? 'active' : ''); ?>">
                        <i class="home icon"></i>
                        <?php echo e(__('app.dashboard')); ?>

                    </a>
                    <a href="<?php echo e(route('frontend.competitions.index')); ?>" class="item <?php echo e(strpos(Route::currentRouteName(),'frontend.competitions.')!==FALSE ? 'active' : ''); ?>">
                        <i class="trophy icon"></i>
                        <?php echo e(__('app.competitions')); ?>

                    </a>
                    <a href="<?php echo e(route('frontend.assets.index')); ?>" class="item <?php echo e(Route::currentRouteName()=='frontend.assets.index' ? 'active' : ''); ?>">
                        <i class="bitcoin icon"></i>
                        <?php echo e(__('app.coins')); ?>

                    </a>
                    <a href="<?php echo e(route('frontend.rankings')); ?>" class="item <?php echo e(Route::currentRouteName()=='frontend.rankings' ? 'active' : ''); ?>">
                        <i class="star icon"></i>
                        <?php echo e(__('app.rankings')); ?>

                    </a>
                    <?php if(config('broadcasting.connections.pusher.key')): ?>
                        <a href="<?php echo e(route('frontend.chat.index')); ?>" class="item <?php echo e(Route::currentRouteName()=='frontend.chat.index' ? 'active' : ''); ?>">
                            <i class="comments outline icon"></i>
                            <?php echo e(__('app.chat')); ?>

                        </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('frontend.help')); ?>" class="item <?php echo e(Route::currentRouteName()=='frontend.help' ? 'active' : ''); ?>">
                        <i class="question icon"></i>
                    </a>
                    <?php if(auth()->check()): ?>
                        <div class="right menu">
                            <div class="ui item dropdown">
                                <div class="text">
                                    <img class="ui avatar image" src="<?php echo e(auth()->user()->avatar_url); ?>">
                                    <?php echo e(auth()->user()->name); ?>

                                </div>
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <?php if(auth()->user()->admin()): ?>
                                        <a href="<?php echo e(route('backend.dashboard')); ?>" class="item">
                                            <i class="setting icon"></i>
                                            <?php echo e(__('app.backend')); ?>

                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('frontend.users.show', auth()->user())); ?>" class="item">
                                        <i class="user icon"></i>
                                        <?php echo e(__('users.profile')); ?>

                                    </a>
                                    <a href="<?php echo e(route('frontend.users.index', auth()->user())); ?>" class="item">
                                        <i class="user icon"></i>
                                        <?php echo e(__('auth.changepassword')); ?>

                                    </a>
                                    

                                    <log-out-button token="<?php echo e(csrf_token()); ?>" class="item">
                                        <i class="sign out alternate icon"></i>
                                        <?php echo e(__('auth.logout')); ?>

                                    </log-out-button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- END Desktop menu -->
            </div>
        </div>
    </div>
</div><?php /**PATH F:\my project\Laravel_chat_task\codecanyon-uRdMItwk-crypto-trading-competitions (1)\resources\views/includes/frontend/header.blade.php ENDPATH**/ ?>