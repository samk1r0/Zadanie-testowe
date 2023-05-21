<script>
import LegColor from './components/LegColor.vue'
import Cloth from './components/Cloth.vue'
import axios from 'axios';

export default{
    components:{
        LegColor,
        Cloth
    },
    mounted(){
      document.querySelectorAll('.img-expander').forEach(el=>{
        el.addEventListener('click',()=>{
          document.querySelector('.img-minimizer').addEventListener('click',() =>{
            document.querySelector('body').style.overflow='auto';
          });
          document.querySelector('body').style.overflow='hidden';
        })
      })
      console.log(document.querySelectorAll('.img-minimizer'))
    },
    methods:{
      clothChosen(res){
        this.cloth = res[0];
        this.clothImage = res[1];
      },
      removeFinalFormBox(){
        this.showFormFinalBoxBg=!this.showFormFinalBoxBg
        document.querySelector('body').style.overflow='auto'
      },
      async onSubmit(){
        if(document.getElementsByTagName('form')[0].checkValidity()){
          const formElement = document.querySelector('form');
          const formData = new FormData(formElement);
          let arrayToSend = {
            'cloth':formData.get('cloth'),
            'layout': formData.get('layout'),
            'leg_color': formData.get('leg_color'),
          }

          await axios.post('http://127.0.0.1:8000/form-submit', arrayToSend)
            .then(() => {
              let formMessageBox = document.querySelector('#summary');
              document.querySelector('body').style.overflow='hidden'
              document.querySelector('.bg').classList.remove('hidden');
              formMessageBox.classList.remove('hidden');
              formMessageBox.classList.add('bg-lime-600');
            })
            .catch(() => {
              let formMessageBox = document.querySelector('#summary');
              document.querySelector('body').style.overflow='hidden'
              document.querySelector('.bg').classList.remove('hidden');
              formMessageBox.classList.remove('hidden');
              formMessageBox.classList.add('bg-red-400');
              formMessageBox.querySelector('h2').innerText="Wysyłka formularza nie powiodła się"
            });
        }
        else{
          document.getElementsByTagName('form')[0].reportValidity();
        };
      },
      legsChosen(res){
        this.chosenLegs=res;
      },
      legCategoryChanged(catId){
        this.legsActiveCategory = catId;
        this.legsToDisplay=this.legs
        if(catId!==''){
          this.legsToDisplay.forEach(leg => leg['cat_id']===catId ? leg['show'] = true : leg['show'] = false );
        }
        else{
          this.legsToDisplay.forEach(leg => leg['show'] = true);
        }
      }
    },
    data(){
      let legs = [
          {
            'image-src':'src/assets/Gloss_velvet.jpg',
            'title':'Gloss velvet',
            'cat_id': 0,
            'input-id':'gloss_velvet_leg',
            'checked': false,
            'show' : true
          },
          {
            'image-src':'src/assets/Venus_Velver.jpg',
            'title':'Venus Velvet',
            'cat_id': 0,
            'input-id':'venus_velvet_leg',
            'checked': false,
            'show' : true
          },
          {
            'image-src':'src/assets/Riviera_91_(Davis).jpg',
            'title':'Riviera 91 (Davis)',
            'cat_id': 1,
            'input-id':'riviera_91_(davis)_leg',
            'checked': false,
            'show' : true
          },
          {
            'image-src':'src/assets/Monolith.jpg',
            'title':'Monolith',
            'cat_id': 1,
            'input-id':'Monolith_leg',
            'checked': false,
            'show' : true
          },
          {
            'image-src':'src/assets/Baloo.jpg',
            'title':'Baloo',
            'cat_id': 3,
            'input-id':'Baloo',
            'show' : true
          },
          {
            'image-src':'src/assets/Braid.jpg',
            'title':'Braid',
            'cat_id': 2,
            'input-id':'Braid',
            'show' : true
          },
          {
            'image-src':'src/assets/Horton.jpg',
            'title':'Horton',
            'cat_id': 2,
            'input-id':'Horton',
            'show' : true
          },
          {
            'image-src':'src/assets/Magic_velvet.jpg',
            'title':'Magic Velvet',
            'cat_id': 3,
            'input-id':'magic_velvet',
            'show' : true
          }
        ]
      return{
        cloth : 'Riviera 91 (Davis)',
        clothImage : 'src/assets/Riviera_91_(Davis).jpg',
        changeClothButton : true,
        legsToDisplay : legs,
        legs,
        legsActiveCategory : '',
        chosenLegs:'',
        layout:'',
        showFormFinalBoxBg: true,
        clothes : [ 
                    {
                      'image-src':'src/assets/Gloss_velvet.jpg',
                      'title':'Gloss velvet',
                      'id':'gloss_velvet'
                    },
                    {
                      'image-src':'src/assets/Venus_Velver.jpg',
                      'title':'Venus Velvet',
                      'id':'venus_velvet'
                    },
                    {
                      'image-src':'src/assets/Riviera_91_(Davis).jpg',
                      'title':'Riviera 91 (Davis)',
                      'id':'riviera_91_(davis)',
                      'checked': 'true'
                    },
                    {
                      'image-src':'src/assets/Monolith.jpg',
                      'title':'Monolith',
                      'id':'Monolith'
                    }
        ],
        
      }
    }
}

</script>

<template>
  <form class="px-4 mx-auto my-0 max-w-xl">
    <section class="my-4 border-4 p-6 w-full"><!-- Tkanina -->
      <div class="flex justify-between">
        <div>
          <h2 class="text-2xl font-bold">1. Tkanina</h2>
          <p>{{ cloth }}</p>
        </div>
        <div class="flex max-sm:flex-col">
          <img class="rounded-full w-16 h-16" :src="clothImage" alt="">
          <button :class="{block: changeClothButton, hidden: !changeClothButton}" @click="changeClothButton=!changeClothButton" 
          class="pl-6 max-sm:pl-0 text-red-600 font-bold" type="button">ZMIEŃ</button>
        </div>
      </div>
      <div :class="{hidden: changeClothButton, block: !changeClothButton}" class="mt-4 grid gap-4 grid-cols-4 max-sm:grid-cols-3 max-[400px]:grid-cols-2 text-center">
        <Cloth v-for="cloth in clothes" 
              @emit-result="clothChosen"
              :imageSrc="cloth['image-src']" 
              :title="cloth['title']" 
              :inputId="cloth['id']" 
              :checked="cloth['checked'] ? 'true' : ''"/>
      </div>
    </section>
    

    <section class="my-4 border-4 p-6 w-full"><!-- Kolor nóżek -->
      <div class="flex justify-between">
          <h2 class="text-2xl font-bold">2. Kolor nóżek</h2>
      </div>
      <div class="flex flex-wrap">
        <input type="radio" id="wszystkie" name="leg_category" class="hidden mr-4 font-bold" @change="legCategoryChanged('')">
        <label :class="{selected : legsActiveCategory===''}" class="cursor-pointer" for="wszystkie">Wszystkie</label>
        <input type="radio" id="bez_doplaty" name="leg_category" class="hidden mr-4 font-bold" @change="legCategoryChanged(0)">
        <label :class="{selected : legsActiveCategory===0}" class="ml-2 cursor-pointer" for="bez_doplaty">Bez dopłaty</label>
        <input type="radio" id="wielur" name="leg_category" class="hidden mr-4 font-bold" @change="legCategoryChanged(1)">
        <label :class="{selected : legsActiveCategory===1}" class="ml-2 cursor-pointer" for="wielur">Wielur</label>
        <input type="radio" id="plecionka" name="leg_category" class="hidden mr-4 font-bold" @change="legCategoryChanged(2)">
        <label :class="{selected : legsActiveCategory===2}" class="ml-2 cursor-pointer" for="plecionka">Plecionka</label>
        <input type="radio" id="ekoskóra" name="leg_category" class="hidden mr-4 font-bold" @change="legCategoryChanged(3)">
        <label :class="{selected : legsActiveCategory===3}" class="ml-2 cursor-pointer" for="ekoskóra">Ekoskóra</label>
      </div>
      <div class="text-center mt-4 grid gap-4 grid-cols-4 max-sm:grid-cols-3 max-[400px]:grid-cols-2">
           <LegColor v-for="leg in legs"
                v-show="leg['show']"
                @emit-result="legsChosen"
                :imageSrc="leg['image-src']" 
                :title="leg['title']" 
                :inputId="leg['input-id']"
            />
      </div>
    </section>

    <section class="my-4 border-4 p-6 w-full"><!-- Układ narożnika -->
      <div class="flex justify-between max-sm:flex-col">
          <h2 class="text-2xl font-bold">3. Układ narożnika</h2>
          <div class="my-auto flex max-sm:flex-start">
            <label class="cursor-pointer" for="left" :class="{selected:layout=='left'}">LEWY</label>
            <input class="opacity-0" @change="layout='left'" type="radio" name="layout" value="left" id="left" required>
            <label for="right" :class="{selected:layout=='right'}" class="cursor-pointer ml-4 max-sm:ml-0">PRAWY</label>
            <input class="opacity-0" @change="layout='right'" type="radio" name="layout" value="right" id="right" required>
          </div>
      </div>
    </section>
    <button class="bg-lime-400 rounded text-white py-2 px-4" @click.prevent="onSubmit">Submit</button>
    <div :class="{hidden:!showFormFinalBoxBg}" id="summary" class="text-center z-10 hidden p-6 rounded fixed text-white top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%]">
      <h2 class="font-bold">Formaularz został pomyślnie wysłany!</h2>
    </div>
    <div class="bg hidden" :class="{hidden:!showFormFinalBoxBg}" @click="removeFinalFormBox"></div>
  </form>  
</template>

<style>
  .selected{
    position: relative;
  }
  .selected::after{
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: red;
  }
  .bg{
    position: fixed;
    background-color: rgba(0,0,0,0.3);
    top: 0;
    height: 100%;
    width: 100%;
    left: 0;
  }
</style>