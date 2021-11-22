<template>
<div>
    <div class="posts">
        <b-row>
            <b-col cols="12" md="6" class="post-content" v-for="(post,index) in posts.data" :key="index">
                <img :src="'/'+post.image" :alt="post.image">
                <h3 class="text-center"><router-link :to="{name:'singlepost',params:{slug:post.slug} }">
                    {{post.title}}</router-link></h3>
                <p>{{stripTags(post.description)}}</p>
            </b-col>
        </b-row>
        <pagination :data="posts" @pagination-change-page="allpost">
            	<span slot="prev-nav">&lt;</span>
                <span slot="next-nav">&gt;</span>
        </pagination>
    </div>
</div>

</template>
<script>
export default {
    data(){
        return{
            posts:{}
        }
    },
    created(){
        this.allpost()
    },
    methods:{
        allpost(page=1){
            axios.get('/api/auth/blog?page='+page)
            .then((res) =>{this.posts = res.data})
        },
        stripTags(str){
            //var stripedHtml = htmlString.replace(/<[^>]+>/g, ``);
            let doc = new DOMParser().parseFromString(str, 'text/html');
            return doc.body.textContent || "";
        },
    }
}
</script>
