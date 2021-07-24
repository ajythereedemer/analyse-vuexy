<template>
  <div>
     <div>
	 <validation-observer ref="simpleRules">
      <b-form
        ref="form"
        :style="{height: trHeight}"
        class="repeater-form"
        @submit.prevent="repeateAgain"
      >
		<b-row
          ref="row"
        >
		<b-col md="12">
            <b-form-group
              label="Title"
              label-for="title-outer"
            >
              <b-form-input
                id="title-outer"
				v-model="title"
                type="text"
                placeholder="Title"
              />
            </b-form-group>
          </b-col>
		</b-row>
        <!-- Row Loop -->
        <b-row
          v-for="(item, index) in items"
          :id="item.id"
          :key="item.id"
          ref="row"
        >
	
          <!-- Item Name -->
          <b-col md="2">
            <b-form-group
              label="Step Name"
              label-for="step-name"
            >
				<validation-provider
              #default="{ errors }"
              name="Step Name "
              rules="required"
            >
              <b-form-input
                id="step-name"
				v-model="items[index].step_name"
				:state="errors.length > 0 ? false:null"
                type="text"
                placeholder="Step Name"
              />
			  <small class="text-danger">{{ errors[0] }}</small>
			  </validation-provider>
            </b-form-group>
          </b-col>

          <!-- Cost -->
          <b-col md="2">
            <b-form-group
              label="Title"
              label-for="title"
            >
			<validation-provider
              #default="{ errors }"
              name="Title "
              rules="required"
            >
              <b-form-input
                id="title"
				:name="'title'+index"
				v-model="items[index].title"
				:state="errors.length > 0 ? false:null"
                type="text"
                placeholder="Title"
              />
				<small class="text-danger">{{ errors[0] }}</small>
			</validation-provider>
            </b-form-group>
          </b-col>

          <!-- Quantity -->
          <b-col md="4">
            <b-form-group
              label="Description"
              label-for="description"
            >
			<validation-provider
              #default="{ errors }"
              name="Description"
              rules="required"
            >
              <b-form-textarea
                id="description"
				v-model="items[index].description"
				:state="errors.length > 0 ? false:null"
                type="text"
                placeholder="Description"
              />
			  <small class="text-danger">{{ errors[0] }}</small> 
			</validation-provider>
            </b-form-group>
          </b-col>

          <!-- Profession -->
          <b-col
            lg="2"
            md="1"
          >
            <b-form-group
              label="Image"
              label-for="image"
            >
              <b-form-file
                :attr=index
                type="text"
				v-on:change="onFileChange"
                placeholder="image"
              />
			  <img :src="items[index].image" class="img-fluid" :key="index" />
			  <input type="hidden" v-model="items[index].id" />
            </b-form-group>
          </b-col>
		  
		  <b-col md="6">
            <b-form-group
              label="Content URL"
              label-for="content_url"
            >
			<validation-provider
              #default="{ errors }"
              name="Content URL"
              rules="required"
            >
              <b-form-input
                id="content_url"
				:name="'content_url'+index"
				v-model="items[index].content_url"
				:state="errors.length > 0 ? false:null"
                type="text"
                placeholder="Content URL"
              />
				<small class="text-danger">{{ errors[0] }}</small>
			</validation-provider>
            </b-form-group>
          </b-col>
		  
		  <b-col md="2">
            <b-form-group
              label="Button Text"
              label-for="button_text"
            >
			<validation-provider
              #default="{ errors }"
              name="Button Text"
              rules="required"
            >
              <b-form-input
                id="button_text"
				:name="'button_text'+index"
				v-model="items[index].button_text"
				:state="errors.length > 0 ? false:null"
                type="text"
                placeholder="Button Text"
              />
				<small class="text-danger">{{ errors[0] }}</small>
			</validation-provider>
            </b-form-group>
          </b-col>

          <!-- Remove Button -->
          <b-col
            lg="2"
            md="3"
            class="mb-50"
          >
            <b-button
              v-ripple.400="'rgba(234, 84, 85, 0.15)'"
              variant="outline-danger"
              class="mt-0 mt-md-2"
              @click="removeItem(index)"
            >
              <feather-icon
                icon="XIcon"
                class="mr-25"
              />
              <span>Delete</span>
            </b-button>
          </b-col>
          <b-col cols="12">
            <hr>
          </b-col>
        </b-row>

      </b-form>
	  </validation-observer>
    </div>
    <b-button
      v-ripple.400="'rgba(255, 255, 255, 0.15)'"
      variant="primary"
      @click="repeateAgain"
    >
      <feather-icon
        icon="PlusIcon"
        class="mr-25"
      />
      <span>Add New</span>
    </b-button>
	<b-button
      v-ripple.400="'rgba(255, 255, 255, 0.15)'"
      variant="primary"
      @click="sumitForm"
    >
      <span>Submit</span>
    </b-button>
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BForm, BFormGroup, BFormInput, BRow, BCol, BButton,BFormTextarea,BFormFile
} from 'bootstrap-vue'
import { heightTransition } from '@core/mixins/ui/transition'
import Ripple from 'vue-ripple-directive'
import axios from 'axios'
import { required, email } from '@validations'

import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
  components: {
    BForm,
	ValidationProvider,
    ValidationObserver,
    BRow,
    BCol,
    BButton,
    BFormGroup,
    BFormFile,
    BFormTextarea,
    BFormInput,
  },
  directives: {
    Ripple,
  },
  mixins: [heightTransition],
  data() {
    return {
      items: [{
        id: '',
        step_name: '',
        title: '',
        description: '',
        content_url: '',
      }],
	  title: '',
	  id: this.$route.params.id,
	  files: [],
	  image: [],
	  required: '',
      nextTodoId: 2,
    }
  },
  mounted() {
    this.initTrHeight()
  },
  created() {
    window.addEventListener('resize', this.initTrHeight)
	this.getData()
  },
  destroyed() {
    window.removeEventListener('resize', this.initTrHeight)
  },
  methods: {
	onFileChange(e) {
		let files = e.target.files || e.dataTransfer.files;
		if (!files.length)
			return;
			
		this.createImage(files[0],e.target.getAttribute("attr"));
	},
	createImage(file,index) {
		let reader = new FileReader();
		let vm = this;
		reader.onload = (e) => {
			vm.image[index] = e.target.result;
		};
		
		reader.readAsDataURL(file);
	},
	uploadImage: function(index) {    
      var file = document
        .findelementbyid('file_'+index)
        .files[0];
      var reader = new FileReader();
      reader.onload = function(e) {
        vm.image = e.target.result             
      };
      reader.onerror = function(error) {
        alert(error);
      };
      reader.readAsDataURL(file);      
    },
    repeateAgain() {
		this.$refs.simpleRules.validate().then(success => {
			if(success){
				this.items.push({
					id: this.nextTodoId += this.nextTodoId,
				})

				this.$nextTick(() => {
					this.trAddHeight(this.$refs.row[0].offsetHeight)
				})
			}
		})
    },
	getData(){
        axios.get('/api/auth/get-data/' + this.id).then(response => 
        {
			if(response.data.multiStep.steps.length > 0)
			{
				this.title = response.data.multiStep.title;
				this.items = response.data.multiStep.steps;
				setTimeout(() => this.initTrHeight(), 1500);
			}
		});
    },
	sumitForm: function () {
		this.$refs.simpleRules.validate().then(success => {
        if (success) {
			axios.post('/api/auth/multiple-data',
			{
			  id:this.id,
			  title:this.title,
			  data:this.items,
			  image:this.image,
			})
			.then((response) => {
				this.$toast({
					component: ToastificationContent,
					position: 'top-right',
					props: {
					  title: `Success`,
					  icon: 'CoffeeIcon',
					  variant: 'success',
					  text: `Steps updated successfully!`,
					},
				  })
				this.getData();
			})
			.catch((err) => {
				let error = {}
				console.log('error is ',err.response.data.msg)
			})
        }
      })
    },
    removeItem(index) {
      this.items.splice(index, 1)
      this.trTrimHeight(this.$refs.row[0].offsetHeight)
    },
    initTrHeight() {
      this.trSetHeight(null)
      this.$nextTick(() => {
        this.trSetHeight(this.$refs.form.scrollHeight+200)
      })
    },
  },
}
</script>

<style lang="scss" scoped>
.repeater-form {
  overflow: hidden;
  transition: .35s height;
}
</style>
