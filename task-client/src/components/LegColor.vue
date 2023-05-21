<script>
  export default{
    props: {
      imageSrc: {
        type: String,
        required: true
      },        
      title: {
        type: String,
        required: true
      },
      inputId:{
        type: String,
        required: true
      }
    },
    data(){
      return{
        expanded: false,
        selected: false,
      }
    }
  }
</script>

<template>
    <div> 
      <div @click="expanded=true;" 
      class="img-expander
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
        <img class="leg-preview mx-auto rounded-full w-16 h-16 object-cover" :src="imageSrc" alt="">
      </div>
      <div v-if="expanded" :class="{expanded:expanded}">
        <img :src="imageSrc" class="z-10 rounded-xl fixed w-1/2 h-1/2 object-cover left-1/2 top-1/2 translate-x-[-50%] translate-y-[-50%]" alt="">
        <span @click="expanded=false" class="img-minimizer z-10 cursor-pointer fixed right-4 top-2 text-3xl text-white">✕</span>
      </div>
      <input type="radio" name="leg_color" :value="inputId" :id="inputId" required>
      <label :for="inputId"  class="cursor-pointer mt-2 font-bold text-sm text-center">{{ title }}</label>
    </div>
</template>

<style>
  .expanded::after{
    content: '';
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 9;
    background-color: rgba(0,0,0,0.5);
    height: 100%;
  }
  input[type='radio']:after {
        width: 15px;
        height: 15px;
        border-radius: 15px;
        top: -4px;
        left: -1px;
        position: relative;
        background-color: #d1d3d1;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 2px solid white;
    }

    input[type='radio']:checked:after {
        width: 15px;
        height: 15px;
        border-radius: 15px;
        top: -4px;
        left: -1px;
        position: relative;
        background-color: #3DED97;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 2px solid white;
    }
</style>