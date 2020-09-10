import polcies from "./policies.js";

export default {
    install(Vue, options) {
        Vue.prototype.authorize = (policy, model) => {
            if (!window.Auth.signedIn) return false;

            if (typeof policy === 'string' && typeof model === 'object') {
                const user = window.Auth.user;

                return polcies[policy](user, model);
            }
        }

        Vue.prototype.signedIn = window.Auth.signedIn;
    }
}
