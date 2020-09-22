/**
 * FormValidation (https://formvalidation.io), v1.0.1
 * The best validation library for JavaScript
 * (c) 2013 - 2018 Nguyen Huu Phuoc <me@phuoc.ng>
 */

(function (global, factory) {
	typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
	typeof define === 'function' && define.amd ? define(factory) :
	(global.FormValidation = global.FormValidation || {}, global.FormValidation.plugins = global.FormValidation.plugins || {}, global.FormValidation.plugins.InvisibleRecaptcha = factory());
}(this, (function () { 'use strict';

var Plugin = FormValidation.Plugin

var Status;
(function (Status) {
    Status["Invalid"] = "Invalid";
    Status["NotValidated"] = "NotValidated";
    Status["Valid"] = "Valid";
    Status["Validating"] = "Validating";
})(Status || (Status = {}));
var Status$1 = Status;

var fetch = FormValidation.utils.fetch

class InvisibleRecaptcha extends Plugin {
    constructor(opts) {
        super(opts);
        this.widgetIds = new Map();
        this.captchaStatus = Status$1.NotValidated;
        this.opts = Object.assign({}, InvisibleRecaptcha.DEFAULT_OPTIONS, opts);
        this.fieldResetHandler = this.onResetField.bind(this);
        this.preValidateFilter = this.preValidate.bind(this);
    }
    install() {
        this.core
            .on('core.field.reset', this.fieldResetHandler)
            .registerFilter('validate-pre', this.preValidateFilter);
        const loadPrevCaptcha = (typeof window[InvisibleRecaptcha.LOADED_CALLBACK] === 'undefined')
            ? () => { }
            : window[InvisibleRecaptcha.LOADED_CALLBACK];
        window[InvisibleRecaptcha.LOADED_CALLBACK] = () => {
            loadPrevCaptcha();
            const captchaOptions = {
                badge: this.opts.badge,
                'error-callback': () => {
                    this.captchaStatus = Status$1.Invalid;
                    this.core.updateFieldStatus(InvisibleRecaptcha.CAPTCHA_FIELD, Status$1.Invalid);
                },
                'expired-callback': () => {
                    this.captchaStatus = Status$1.NotValidated;
                    this.core.updateFieldStatus(InvisibleRecaptcha.CAPTCHA_FIELD, Status$1.NotValidated);
                },
                sitekey: this.opts.siteKey,
                size: this.opts.size,
            };
            const widgetId = window['grecaptcha'].render(this.opts.element, captchaOptions);
            this.widgetIds.set(this.opts.element, widgetId);
            this.core.addField(InvisibleRecaptcha.CAPTCHA_FIELD, {
                validators: {
                    promise: {
                        message: this.opts.message,
                        promise: (input) => {
                            if (input.value === '') {
                                this.captchaStatus = Status$1.Invalid;
                                return Promise.resolve({
                                    valid: false,
                                });
                            }
                            else if (this.opts.backendVerificationUrl === '') {
                                this.captchaStatus = Status$1.Valid;
                                return Promise.resolve({
                                    valid: true,
                                });
                            }
                            else if (this.captchaStatus === Status$1.Valid) {
                                return Promise.resolve({
                                    valid: true,
                                });
                            }
                            else {
                                return fetch(this.opts.backendVerificationUrl, {
                                    method: 'POST',
                                    params: {
                                        [InvisibleRecaptcha.CAPTCHA_FIELD]: input.value,
                                    },
                                }).then((response) => {
                                    const isValid = `${response['success']}` === 'true';
                                    this.captchaStatus = isValid ? Status$1.Valid : Status$1.Invalid;
                                    return Promise.resolve({
                                        meta: response,
                                        valid: isValid,
                                    });
                                }).catch((reason) => {
                                    this.captchaStatus = Status$1.NotValidated;
                                    return Promise.reject({
                                        valid: false,
                                    });
                                });
                            }
                        },
                    },
                },
            });
        };
        const src = this.getScript();
        if (!document.body.querySelector(`script[src="${src}"]`)) {
            const script = document.createElement('script');
            script.type = 'text/javascript';
            script.async = true;
            script.defer = true;
            script.src = src;
            document.body.appendChild(script);
        }
    }
    uninstall() {
        this.core
            .off('core.field.reset', this.fieldResetHandler)
            .deregisterFilter('validate-pre', this.preValidateFilter);
        this.widgetIds.clear();
        const src = this.getScript();
        const scripts = [].slice.call(document.body.querySelectorAll(`script[src="${src}"]`));
        scripts.forEach((s) => s.parentNode.removeChild(s));
        this.core.removeField(InvisibleRecaptcha.CAPTCHA_FIELD);
    }
    getScript() {
        const lang = this.opts.language ? `&hl=${this.opts.language}` : '';
        return `https://www.google.com/recaptcha/api.js?onload=${InvisibleRecaptcha.LOADED_CALLBACK}&render=explicit${lang}`;
    }
    preValidate() {
        if (this.widgetIds.has(this.opts.element)) {
            const widgetId = this.widgetIds.get(this.opts.element);
            return this.captchaStatus === Status$1.Valid
                ? Promise.resolve()
                : new Promise((resolve, reject) => {
                    window['grecaptcha'].execute(widgetId).then(() => {
                        this.timer && clearTimeout(this.timer);
                        this.timer = window.setTimeout(resolve, 1 * 1000);
                    });
                });
        }
        else {
            return Promise.resolve();
        }
    }
    onResetField(e) {
        if (e.field === InvisibleRecaptcha.CAPTCHA_FIELD && this.widgetIds.has(this.opts.element)) {
            const widgetId = this.widgetIds.get(this.opts.element);
            window['grecaptcha'].reset(widgetId);
        }
    }
}
InvisibleRecaptcha.CAPTCHA_FIELD = 'g-recaptcha-response';
InvisibleRecaptcha.DEFAULT_OPTIONS = {
    badge: 'bottomright',
    size: 'invisible',
    backendVerificationUrl: '',
};
InvisibleRecaptcha.LOADED_CALLBACK = '___invisibleRecaptchaLoaded___';

return InvisibleRecaptcha;

})));
