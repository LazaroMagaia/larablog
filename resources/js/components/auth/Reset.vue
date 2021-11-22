<template>
    <div class="container">
        <div class="login text-center">
            <h1 class="title">Recuperar a senha</h1>
            <form @submit.prevent="reset">
                <div class="text-center">
                    <input type="text" placeholder="Senha" v-model="form.password">
                    <small class="text-danger" v-if="errors.password">
                        {{errors.password[0]}}
                    </small>
                </div>
                <div class="text-center">
                    <input type="text" placeholder="Confirmacao da senha" v-model="form.password_confirmation">
                </div>

                <input type="submit" value="Entrar">
            </form>
        </div><!--login-->
    </div>
</template>
<script>
export default {
    created(){
        if(User.loggedIn())
        {
            this.$router.push({name: 'home'})
        }
    },
    data(){
        return{
            form:{
                token: this.$route.params.token,
                password:'',
                password_confirmation:''
            },
            errors:{}
        }
    },
    methods:{
        async reset(){
        await axios.post('/api/auth/reset',this.form)
            .then(res =>{
                User.responseAfterLogin(res);
                Toast.fire({
                icon: 'success',
                title: 'Senha trocada com sucesso'
                })
                this.$router.push({name: 'login'});
            })
            .catch(error =>this.errors= error.response.data.errors)
        }
    }
}
</script>
