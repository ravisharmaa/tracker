let user = Window.app.user;
let isLoggedIn = Window.app.isLoggedIn;


module.exports = {
    user : {
        email() {
            if (isLoggedIn) {
                return user.email;
            }
            return false;
        },

        name() {
            return user.name;
        }
    }
};
