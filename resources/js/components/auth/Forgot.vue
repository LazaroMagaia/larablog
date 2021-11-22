<template>
    <div class="container">
        <Navbar/>
        <div class="login text-center">
            <h1 class="title">Esqueci a minha senha</h1>
            <form @submit.prevent="esqueci">
                <div class="text-center">
                    <input type="text" placeholder="Email" v-model="form.email">
                    <small class="text-danger" v-if="errors.email">
                        {{errors.email[0]}}
                    </small>
                </div>

                <input type="submit" value="Entrar">
            </form>
        </div><!--login-->
    </div>
</template>
<script>
import Navbar from '../blogComponent/NavBar.vue';
export default {
    created(){
        if(User.loggedIn())
        {
            this.$router.push({name: 'home'})
        }
    },
    components:{
        Navbar
    },
    data(){
        return{
            form:{
                email:'',
            },
            errors:{}
        }
    },
    methods:{
        async esqueci(){
        await axios.post('/api/auth/forgot',this.form)
            .then(res =>{
                Toast.fire({
                icon: 'success',
                title: 'Verifique o seu email'
                })
                User.responseAfterLogin(res);
            })
            .catch(error =>this.errors= error.response.data.errors)
            .catch(Toast.fire({
                icon: 'warning',
                title: 'Email invalido'
                }))
        }
    }
}
</script>
