/**
 * @module ui/login.reel
 * @requires montage/ui/component
 */
var Component = require("montage/ui/component").Component;

/**
 * @class Login
 * @extends Component
 */
exports.Login = Component.specialize(/** @lends Login# */ {
    constructor: {
        value: function Login() {
            this.super();
        }
    },
    templateDidLoad: {
        value: function() {
            console.log("templateDidLoad");
        }
    },
    handleCredentialsButtonAction: {
        value: function() {
            console.log("credentials login action!");
        }
    },
    handleButtonAction: {
        value: function() {
            console.log("login action!");
        }
    }
});
