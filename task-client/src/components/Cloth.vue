<script>
  export default{
    props: {
      imageSrc: {
        type: String,
        required: true
      }, 
      inputId:{
        type: String,
        required: true
      },    
      title: {
        type: String,
        required: true
      },
      checked: {
        type: String
      }
    },
    methods:{
      clothChosen(){
        this.$emit("emit-result", [this.title,this.imageSrc])
      }
    },
    data(){
      return{
        expanded: false,
      }
    }
  }
</script>

<template>
    <div> 
      <div @click="expanded=true" class="
                  img-expander
                  relative
                  cursor-pointer
                  after:content-loopIcon 
                  after:ml-0.5 
                  after:text-red-500
                  after:absolute
                  after:w-6
                  after:h-6
                  after:right-[50%]
                  after:top-[50%]
                  after:left-[50%]
                  after:translate-x-[-50%]
                  after:translate-y-[-50%]
                  ">
        <img class="mx-auto rounded-full w-16 h-16 object-cover" v-bind:src="imageSrc" alt="">
      </div>
      <div v-if="expanded" :class="{expanded:expanded}">
        <img :src="imageSrc" class="z-10 rounded-xl fixed w-1/2 h-1/2 object-cover left-1/2 top-1/2 translate-x-[-50%] translate-y-[-50%]" alt="">
        <span @click="expanded=false" class="img-minimizer z-10 cursor-pointer fixed right-4 top-2 text-3xl text-white">✕</span>
      </div>
      <input @change="clothChosen" type="radio" name="cloth" :value="inputId" v-bind:id="inputId" :checked="checked!=''">
      <label v-bind:for="inputId" class="cursor-pointer mt-2 font-bold text-sm text-center">{{ title }}</label>
    </div>
</template>