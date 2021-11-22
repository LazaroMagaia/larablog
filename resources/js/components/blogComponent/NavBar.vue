<template>
    <div>
        <div class="container">
        <b-navbar toggleable="lg" type="dark" class="fixed-top" variant="white">
            <router-link to="/" class="logo"><img src="/images/logotipo.png" alt="logotipo" srcset=""></router-link>

            <b-navbar-toggle target="nav-collapse" style="background:#444;"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav class="ms-auto">
                <router-link to="/" class="nav-link">Sobre</router-link>
                <router-link to="/" class="nav-link">Contacto</router-link>
                <router-link v-show="!navshow" to="/login" class="nav-link">Entrar</router-link>
                <router-link v-show="navshow" to="/painel" class="nav-link">Painel</router-link>
            </b-navbar-nav>

            <b-navbar-nav class="ml-auto social-icons">
                <a href="" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="" target="_blank"><i class="fab fa-youtube"></i></a>
            </b-navbar-nav>

            </b-collapse>
        </b-navbar>
        </div><!--container-->
    </div>
</template>
<script>
export default {
    data(){
        return{
            navshow:''
        }
    },
        created(){
        if(User.loggedIn())
        {
            this.navshow = true;
        }else
        {
           this.navshow = false;
        }
    },
}
</script>
