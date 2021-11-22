<template>
    <div>
        <Navbar/>
        <div class="single-post" style="padding:0 20px; border-radius:10px;">
            <b-row class="row">
                <b-col cols="12" md="9" class="singlepost-content" style="margin-top:20px;">
                    <img :src="'/'+posts.image" :alt="posts.image" style="border-radius:10px;">
                    <h3 class="text-center">{{posts.title}}</h3>
                    <h4 class="flex"><span>Autor: <strong>{{posts.author}}</strong></span>
                    <span>{{Newdate(posts.date)}}</span>
                    </h4>
                    <div v-html="posts.description"></div>
                </b-col>
                <b-col cols="12" md="3">
                    <Sidebar/>
                </b-col>
            </b-row>
        </div><!--single-post-->
    </div>
</template>
<script>
import Sidebar from '../blogComponent/sidebar.vue'
import Navbar from '../blogComponent/NavBar.vue'
export default {
    data(){
        return{
        slug:'',
        posts:[],
        }
    },
    components:{
        Sidebar,
        Navbar
    },
    methods:{
        allposts(){
            this.slug = this.$route.params.slug
            axios.get("/api/auth/blog/"+this.slug)
            .then(({data})=>{this.posts = data})
            .catch()
        },
        Newdate(date){
            const option = {
                year: 'numeric',
                month: 'long',
                weekday: 'long',
                day: 'numeric',
                /*hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                era: 'long',
                timeZoneName: 'long'*/
            }
            return new Date(date).toLocaleDateString('pt-pt',option)
        },
    },
    created(){
        this.allposts();
    }
}
</script>
