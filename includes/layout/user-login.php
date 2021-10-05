

<div class="ff-request-board-login-register-wrap">
    <div class="ff-request-board-login-register-overlay"></div>
    <div class="ff-request-board-login-register-inner">
        <div class="ff-request-board-login-register-nav">
            <button class="btn-login active">
                <?php esc_html_e('Login', 'fluent-features-board'); ?>
            </button>
            <button class="btn-register">
                <?php esc_html_e('Register', 'fluent-features-board'); ?>
            </button>
        </div>
        <div class="ff-request-board-login-register-body">
            <form class="active" id="ff-request-board-login">
                <h2><?php esc_html_e('Login', 'fluent-features-board'); ?></h2>
                <p class="ffrb-msg-status"></p>
                <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>
                <div class="input-group">
                    <label class="label-text" for="username">
                        <?php esc_html_e('Username', 'fluent-features-board'); ?>
                    </label>
                    <input
                        class="form-control"
                        id="username"
                        type="text"
                        name="name"
                        placeholder="<?php esc_attr_e('username', 'fluent-features-board'); ?>">
                </div>
                <div class="input-group">
                    <label for="password">
                        <?php esc_html_e('Password', 'fluent-features-board'); ?>
                    </label>
                    <input
                        class="form-control"
                        id="password"
                        type="password"
                        placeholder="<?php esc_attr_e('password', 'fluent-features-board'); ?>">
                </div>
                <div class="input-group btn-box">
                    <button id="ffb-login-submit" type="submit" class="theme-btn w-100">
                        <?php esc_html_e('Login', 'fluent-features-board'); ?>
                    </button>
                </div>
            </form>
            <form id="ff-request-board-register">
                <h2><?php esc_html_e('Register', 'fluent-features-board'); ?></h2>
                <p class="ffrb-msg-status"></p>
                <?php //wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>
                <div class="input-group">
                    <label class="label-text" for="username">
                        <?php esc_html_e('Username', 'fluent-features-board'); ?>
                    </label>
                    <input
                        class="form-control"
                        type="text"
                        name="reg-username"
                        id="reg-username"
                        placeholder="<?php esc_attr_e('username', 'fluent-features-board'); ?>">
                </div>
                <div class="input-group">
                    <label for="password">
                        <?php esc_html_e('Email', 'fluent-features-board'); ?>
                    </label>
                    <input
                        class="form-control"
                        type="text"
                        name="email"
                        id="reg-email"
                        placeholder="<?php esc_attr_e('email', 'fluent-features-board'); ?>">
                </div>
                <div class="input-group">
                    <label for="reg-password">
                        <?php esc_html_e('Password', 'fluent-features-board'); ?>
                    </label>
                    <input
                        class="form-control"
                        type="password"
                        name="password"
                        id="reg-password"
                        placeholder="<?php esc_attr_e('password', 'fluent-features-board'); ?>">
                </div>
                <div class="input-group">
                    <label for="reg-password2">
                        <?php esc_html_e('Confirm Password', 'fluent-features-board'); ?>
                    </label>
                    <input
                        class="form-control"
                        type="password"
                        name="password2"
                        id="reg-password2"
                        placeholder="<?php esc_attr_e('Confirm password', 'fluent-features-board'); ?>">
                </div>
                <div class="input-group btn-box">
                    <button id="ffb-register-submit" type="submit" class="theme-btn w-100">
                        <?php esc_html_e('Register', 'fluent-features-board'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>