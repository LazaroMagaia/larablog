<template>
    <div class="container">
        <Navbar/>
        <div class="login text-center">
            <h1 class="title">Criar nova conta</h1>
            <form @submit.prevent="register" enctype="multipart/form-data">
                <div class="">
                    <input type="text" placeholder="Nome" v-model="form.name">
                    <small class="text-danger" v-if="errors.name">
                        {{errors.name[0]}}
                    </small>
                </div>
                <div class="">
                    <input type="text" placeholder="Email" v-model="form.email">
                    <small class="text-danger" v-if="errors.email">
                        {{errors.email[0]}}
                    </small>
                </div>
                <div class="">
                    <input type="password" placeholder="Senha" v-model="form.password">
                    <small class="text-danger" v-if="errors.password">
                        {{errors.password[0]}}
                    </small>
                </div>
                <div class="">
                    <input type="password" placeholder="Confirmacao de senha" v-model="form.password_confirmation">
                    <small class="text-warning" v-if="errors.password_confirmation">
                        {{errors.password_confirmation[0]}}
                    </small>
                </div>
                <input type="submit" value="Criar conta">
            </form>
            <div class="">
                <router-link to="/login" class="font-weight-bold small" >Já tem uma conta ?</router-link>
            </div><!--Login-acount-->
        </div><!--register-->
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
                name:'',
                email:'',
                image:'',
                password:'',
                password_confirmation:'',
                image_error:''
            },
            errors:{}
        }
    },
    methods:{
        register(){
            axios.post('/api/auth/signup',this.form)
            .then(res =>{
                User.responseAfterLogin(res);
                this.$router.push({name: 'login'});
                    Toast.fire({
                    icon: 'success',
                    title: 'signup in successfully'
                })
            })
            .catch(error =>this.errors= error.response.data.errors)
        },
            onFileSelected(event){
            let file = event.target.files[0];
            if(file.size > 1048770){
                image_error = "Imagem invalida"
            }else
            {
                let reader = new FileReader();
                reader.onload = event =>{
                    this.form.image = event.target.result
                    console.log(event.target.result)
                };
                reader.readAsDataURL(file);
            }
        }
    }
}
</script>
