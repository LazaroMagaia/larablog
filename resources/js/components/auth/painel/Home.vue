<template>
    <div>
        <NavBar/>
        <Noty/>
        <div class="home">
            <div class="blog-wrapper">
                <router-link :to="{name:'painel-create'}" class="btn btn-primary criar">Novo artigo</router-link>
                <div>
                    <form class="form form-inline" @submit.prevent="searchBlog">
                        <input type="text" v-model="form.KeySearch" class="form-control mt-4 mb-4"
                        placeholder="Procuro por...">
                        <button class="btn btn-primary" type="submit">Pesquisar</button>
                    </form>
                </div>
                <b-row>
                    <b-col cols="12" md="3" class="blog-content" v-for="post in posts.data" :key="post.id">
                        <img :src="'/'+post.image" :alt="post.image">
                        <h3 class="text-center"><router-link
                        :to="{name:'singlepost',params:{slug:post.slug}}">{{post.title}}
                        </router-link></h3>
                        <p v-html="post.description">{{}}</p>
                        <router-link :to="{name:'painel-update',params:{id:post.id}}"
                        class="btn btn-warning">Editar</router-link>
                        <button @click="remover(post.id)" class="btn btn-danger">Remover</button>
                        <hr>
                    </b-col>
                </b-row>
                <pagination :data="posts" @pagination-change-page="allPosts">
                    <span slot="prev-nav">&lt;</span>
                    <span slot="next-nav"> &gt;</span>
                </pagination>
            </div><!--blog-wrapper-->
        </div>
    </div>
</template>
<script>
import NavBar from './components/Navbar.vue'
import Noty from './taiwindNoty.vue'
export default {
        data(){
        return{
            posts: {},
            form:{
                KeySearch:'',
            }
        }
    },
    computed:{
        filtersearch(){
        return this.posts.filter(post=>{
          return post.titletoLowerCase().includes(this.keyword.toLowerCase()).match(this.search)
        });
      },
    },
    created(){
        this.allPosts();
        if(User.loggedIn())
        {
            this.$router.push({name: 'painel'})
        }else
        {
            this.$router.push({name: 'login'})
        }
    },
    components:{
        NavBar,
        Noty,
    },
    methods:{
        remover(id){
            axios.delete('/api/auth/blog/'+id)
            .then(()=>{
                    this.$notify({
                    group: "top",
                    title: "Sucesso",
                    text: "Artigo removido com sucesso"
                    },4000)
                    this.allPosts();
                }).catch(()=>{
                    this.$notify({
                    group: "erro",
                    title: "Erro",
                    text: "Erro na remoção do Artigo"
                    },4000)
                  this.$router.push({name:'painel'})
                })
        },
        allPosts(page=1){
            axios.get(`/api/auth/blog?page=`+page)
            .then((res) =>{this.posts = res.data})
        },
        searchBlog(page=1){
            axios.post(`/api/auth/search?page=${page}`,this.form)
            .then((res) =>{this.posts = res.data})
        }
    }
}
</script>
