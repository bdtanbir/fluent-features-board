<template>
    <header>
        <div class="ffr-wrap">
            <div class="header-left">
                <img :src="logo" alt="">
                <div class="header-left-content">
                    <h3><router-link to="/">RoadMap</router-link></h3>
                    <div class="links">
                        <a href="https://adreastrian.com/">AuthLab Homepage</a>
                    </div>
                </div>
            </div>
            <div class="header-right">

                <ul>
                    <li><a class="user-login user-in" href="#">Login</a></li>
                    <li class="user-logout user-out">
                        <a href="#" @click.prevent="showDropdownHandle">
                            Hi Tanbir <span class="downicon"></span>
                        </a>
                        <div v-show="isDropdown" class="user-logout-dropdown">
                            <a class="user-logout" href="#">
                                <span class="logout-power-icon"></span> Logout
                            </a>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </header>
</template>

<script>
export default {
    data() {
        return {
            logo: require('@/frontend/images/logo.png'),
            isDropdown: false
        }
    },
    methods: {
        showDropdownHandle() {
            this.isDropdown = !this.isDropdown;
        }
    },
}
</script>

<style>
    #ff-requests-frontend-app header {
        border-bottom: 1px solid #eee;
        padding: 10px 0;
    }
    #ff-requests-frontend-app .ffr-wrap {
        max-width: 700px;
        margin: auto;
    }
    #ff-requests-frontend-app header .ffr-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    #ff-requests-frontend-app header .header-left {
        display: flex;
        align-items: center;
    }
    #ff-requests-frontend-app header .header-left .header-left-content {
        padding-left: 15px;
    }
    #ff-requests-frontend-app header .header-left .header-left-content h3 {
        font-size: 22px;
        font-weight: 400;
        margin-bottom: 10px;
    }
    #ff-requests-frontend-app header .header-left .header-left-content h3 a {
        text-decoration: none;
        color: #ba42ec;
    }
    #ff-requests-frontend-app header .header-left .header-left-content .links a {
        color: #878787;
        font-size: 15px;
        text-decoration: none;
    }
    #ff-requests-frontend-app header .header-left .header-left-content .links a:hover {
        color: #000;
    }
    #ff-requests-frontend-app header .header-right .user-login {
        text-decoration: none;
        font-size: 15px;
        background: #f1f1f1;
        padding: 5px 15px;
        display: none;
        border-radius: 4px;
        color: #555;
        line-height: 20px;
        transition: .3s;
    }
    #ff-requests-frontend-app header .header-right .user-login.user-in {
        display: inline-block;
    }
    #ff-requests-frontend-app header .header-right ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    #ff-requests-frontend-app header .header-right ul .user-logout-dropdown a:hover,
    #ff-requests-frontend-app header .header-right ul .user-login:hover {
        color: #ba42ec;
        background: #f8e8ff;
    }
    #ff-requests-frontend-app header .header-right ul .user-logout-dropdown a:focus,
    #ff-requests-frontend-app header .header-right ul .user-login:focus {
        outline: none;
    }
    #ff-requests-frontend-app header .header-right ul .user-logout {
        position: relative;
    }
    #ff-requests-frontend-app header .header-right ul .user-logout.user-out {
        display: none;
    }
    #ff-requests-frontend-app header .header-right ul .user-logout a {
        text-decoration: none;
    }
    #ff-requests-frontend-app header .header-right ul .user-logout > a {
        font-size: 14px;
        color: #878787;
        position: relative;
        padding: 5px 15px 5px 10px;
    }
    #ff-requests-frontend-app header .header-right ul .user-logout > a .downicon {
        width: 6px;
        height: 6px;
        border-left: 2px solid #878787;
        border-bottom: 2px solid #878787;
        display: inline-block;
        position: absolute;
        right: 2px;
        bottom: 10px;
        transform: rotate(-45deg);
    }
    #ff-requests-frontend-app header .header-right ul .user-logout-dropdown {
        position: absolute;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 4px;
        box-shadow: 0 0 10px rgb(187 68 236 / 17%);
        padding: 10px;
        min-width: 160px;
        right: 0;
    }
    #ff-requests-frontend-app header .header-right ul .user-logout-dropdown a {
        font-size: 15px;
        font-weight: 300;
        padding: 7px 12px;
        display: flex;
        align-items: center;
        border-radius: 4px;
        transition: .3s;
        color: #878787;
    }
    .logout-power-icon {
        width: 16px;
        height: 16px;
        display: inline-block;
        border: 1px solid #cfcfcf;
        border-radius: 50%;
        margin-right: 5px;
        position: relative;
        transform: translateY(2px);
        transition: .3s;
    }
    .logout-power-icon:before {
        content: '';
        position: absolute;
        width: 1px;
        height: 8px;
        background: #cfcfcf;
        left: 50%;
        top: -4px;
        margin-left: -.5px;
        box-shadow: 0 0 0 3px #fff;
        transition: .3s;
    }
    #ff-requests-frontend-app header .header-right ul .user-logout-dropdown a:hover .logout-power-icon {
        border-color: #ba42ec;
    }
    #ff-requests-frontend-app header .header-right ul .user-logout-dropdown a:hover .logout-power-icon:before {
        box-shadow: 0 0 0 3px #f8e8ff;
        background: #ba42ec;
    }
</style>