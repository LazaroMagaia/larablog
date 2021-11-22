<template>
    <div class="container">
        <Navbar/>
        <div class="login text-center">
            <h1 class="title">Iniciar sessão</h1>
            <form @submit.prevent="login">
                <div class="text-center">
                    <input type="text" placeholder="Email" v-model="form.email">
                </div>
                <div class="text-center">
                    <input type="password" placeholder="Senha" v-model="form.password">
                </div>
                <input type="submit" value="Entrar">
            </form>
            <div class="text-center">
                <router-link to="/register" class="font-weight-bold small" >
                Crie nova conta
                </router-link>
            </div><!--Create an Account!-->
            <div class="text-center">
                <router-link to="/forgot" class="font-weight-bold small" >Esqueceu a senha</router-link>
            </div><!--forgot password-->
        </div><!--login-->
    </div>
</template>
<script>
import Navbar from '../blogComponent/NavBar.vue';
export default {
    created(){
        if(User.loggedIn())
        {
            this.$router.push({name: 'painel'})
        }
    },
    components:{
        Navbar
    },
    data(){
        return{
            form:{
                email:'',
                password:''
            },
            errors:{}
        }
    },
    methods:{
        async login(){
        await axios.post('/api/auth/login',this.form)
            .then(res =>{
                 this.$router.push({name: 'painel'});
                User.responseAfterLogin(res);
                 Toast.fire({
                icon: 'success',
                title: 'logado com sucesso'
                })
            })
            .catch(
                Toast.fire({
                icon: 'warning',
                title: 'Email ou password invalidos'
            }))
        }
    }
}
</script>
