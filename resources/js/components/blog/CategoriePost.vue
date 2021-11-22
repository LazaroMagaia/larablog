
<template>
    <div>
    <Navbar/>
    <b-row class="row" style="margin-top:80px">
        <b-col cols="12" md="12">
            <div class="posts">
                <!--<div class="mb-2 ">
                    <form class="form form-inline">
                        <input type="text" class="form-control" placeholder="pesquisar na categoria...">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                    </form>
                </div>-->
                <b-row>
                    <b-col cols="12" md="4" class="post-content" v-for="(post,index) in posts.data" :key="index">
                        <img :src="'/'+post.image" :alt="post.image">
                        <h3 class="text-center"><router-link :to="{name:'singlepost',params:{slug:post.slug} }">
                            {{post.title}}</router-link></h3>
                        <p> {{post.description}}
                        </p>
                    </b-col>
                </b-row>
                <pagination :data="posts" @pagination-change-page="allpost">
                        <span slot="prev-nav">&lt;</span>
                        <span slot="next-nav">&gt;</span>
                </pagination>
            </div>
        </b-col>
    </b-row>
    </div>
</template>
<script>
import Posts from '../blogComponent/Posts.vue'
import Sidebar from '../blogComponent/sidebar.vue'
import Navbar from '../blogComponent/NavBar.vue'
import Noty from '../auth/painel/taiwindNoty.vue'
export default {
    data(){
        return{
            form:{
            title:'',
            },
            posts:{}
        }
    },
    components:{
        Sidebar,
        Navbar,
        Noty
    },
    methods:{
        allBlog(page=1){
            this.form.title = this.$route.params.categorie
            axios.post('/api/auth/CategorieSearch?page='+page,this.form)
            .then((res) =>{this.posts = res.data})
        }
    },
    created(){
        this.allBlog();
    }
}
</script>
