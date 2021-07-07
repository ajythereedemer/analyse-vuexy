<template>
  <div>
     <div>
      <b-form
        ref="form"
        :style="{height: trHeight}"
        class="repeater-form"
        @submit.prevent="repeateAgain"
      >

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
              <b-form-input
                id="step-name"
				v-model="items[index].step_name"
                type="text"
                placeholder="Step Name"
              />
            </b-form-group>
          </b-col>

          <!-- Cost -->
          <b-col md="2">
            <b-form-group
              label="Title"
              label-for="title"
            >
              <b-form-input
                id="title"
				v-model="items[index].title"
                type="text"
                placeholder="Title"
              />
            </b-form-group>
          </b-col>

          <!-- Quantity -->
          <b-col md="4">
            <b-form-group
              label="Description"
              label-for="description"
            >
              <b-form-textarea
                id="description"
				v-model="items[index].description"
                type="text"
                placeholder="Description"
              />
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
                id="image"
                type="text"
                placeholder="image"
              />
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
import {
  BForm, BFormGroup, BFormInput, BRow, BCol, BButton,BFormTextarea,BFormFile
} from 'bootstrap-vue'
import { heightTransition } from '@core/mixins/ui/transition'
import Ripple from 'vue-ripple-directive'
import axios from 'axios'

export default {
  components: {
    BForm,
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
        step_name: '',
        title: '',
        description: '',
      }],
      nextTodoId: 2,
    }
  },
  mounted() {
    this.initTrHeight()
  },
  created() {
    window.addEventListener('resize', this.initTrHeight)
  },
  destroyed() {
    window.removeEventListener('resize', this.initTrHeight)
  },
  methods: {
    repeateAgain() {
      this.items.push({
        id: this.nextTodoId += this.nextTodoId,
      })

      this.$nextTick(() => {
        this.trAddHeight(this.$refs.row[0].offsetHeight)
      })
    },
	sumitForm: function () {
      console.log(this.items);
	  axios.post('/api/auth/multiple-data',
		{
		  data:this.items,
		})
		.then((response) => {
		
		})
		.catch((err) => {
			let error = {}
			console.log('error is ',err.response.data.msg)
		})
    },
    removeItem(index) {
      this.items.splice(index, 1)
      this.trTrimHeight(this.$refs.row[0].offsetHeight)
    },
    initTrHeight() {
      this.trSetHeight(null)
      this.$nextTick(() => {
        this.trSetHeight(this.$refs.form.scrollHeight)
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
