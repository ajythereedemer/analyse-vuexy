<template>
    <div>
    <b-form >
		<div id="mutistep">
		<vue-cloneya :maximum="10">
		<b-row  v-cloneya-input>
		<b-col
          cols="12"
          md="4"
        >
          <b-form-group
            label="Step Title"
            label-for="step_title"
          >
            <b-form-input
              id="step_title"
              name="data[][step_title]"
              required="required"
            />
          </b-form-group>
        </b-col>
        <b-col
          cols="12"
          md="4"
        >
          <b-form-group
            label="Title"
            label-for="title"
          >
            <b-form-input
              id="title"
              name="data[][title]"
            />
          </b-form-group>
        </b-col>
		<b-col
          cols="12"
          md="4"
        >
          <b-form-group
            label="Description"
            label-for="description"
          >
            <b-form-textarea
				id="description"
				name="data[][description]"
				rows="8"
			  />
          </b-form-group>
        </b-col>
		<b-col
          cols="12"
          md="3"
        >
          <b-form-group
            label="Image"
            label-for="file"
          >
            <b-form-file
			  id="file"
				name="data[][file]"
			  class="mt-1"
			  plain
			/>
          </b-form-group>
        </b-col>
		<span class="input-group-btn">
        <!-- Add the "v-cloneya-add" directive to elements you wish to add the click listener
        that will clone the root element -->
        <button type="button" class="btn btn-success" tabindex="-1" v-cloneya-add>
            <i class="fa fa-plus"></i>
        </button>
        <!-- Add the "v-cloneya-remove" directive to elements you wish to add the click listener
        that will remove the element -->
        <button type="button" class="btn btn-danger" tabindex="-1"  v-cloneya-remove>
          <i class="fa fa-minus"></i>
        </button>
      </span>
		</b-row>
		</vue-cloneya>
    </div>
	<input class="btn" type="button" @click="submitForm" value="Submit"/>
    </b-form>
</div>

</template>

<script>
import {
  BButton, BMedia, BAvatar,BFormTextarea,BFormFile, BRow, BCol, BFormGroup, BFormInput, BForm, BTable, BCard, BCardHeader, BCardTitle, BFormCheckbox,
} from 'bootstrap-vue'
import { avatarText } from '@core/utils/filter'
import vSelect from 'vue-select'
import Vue      from 'vue'
import VueCloneya from 'vue-cloneya'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from '@vue/composition-api'
import axios from 'axios'

Vue.use(VueCloneya)

export default {
  components: {
    BButton,
    BMedia,
    BAvatar,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BFormFile,
    BFormTextarea,
    BForm,
    BTable,
    BCard,
    BCardHeader,
    BCardTitle,
    BFormCheckbox,
    vSelect,
  },  
  data() {
    return {
		data: [
			{
				title: '',
				step_title: '',
				description: '',
				file: ''
			}
		]
    }
  },
  methods: {
    submitForm() {
      //working api for the login
	  console.log(this.data)
       axios.post('/api/auth/multiple-data',
		{
		  data:this.data,
		})
		.then((response) => {
		
		})
		.catch((err) => {
			let error = {}
			console.log('error is ',err.response.data.msg)
		})
    },
  },
	props: {
    data: [
			{
				title: '',
				step_title: '',
				description: '',
				file: ''
			}
		],
  },
  setup(props) {
    // ? Demo Purpose => Update image on click of update
    const refInputEl = ref(null)
    const previewEl = ref(null)

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      // eslint-disable-next-line no-param-reassign
    })

    return {
      avatarText,
      //  ? Demo - Update Image on click of update button
      refInputEl,
      previewEl,
      inputImageRenderer,
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
</style>