<template>
  <div class="multisteps">
<ul class="d-flex flex-wrap justify-content-between align-middle multi-tabs">
  <li class="inline-list" v-for="item in multistep"
  :key="item.id"
        >
    <a href="javascript:void(0)" class="tab-link"><span class="tabs-icon"><img :src="imgUrl" alt="STEP 1" /></span><span class="tabs-text">{{item.title}}</span></a>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade">1...</div>
  <div class="tab-pane fade" id="step2">2...</div>
  <div class="tab-pane " id="step3" v-for="(item, index) in multistep"
  :key="item.id" :class="index == 0 ? 'show active' : 'fade'">
	  <div class="multi-tabs-data">
		  <div class="d-flex flex-wrap justify-content-between row-tabs-steps">
			  <div class="tabs-data-image">
				  <div class="block-image">
					<img :src="item.image"  alt="Headline Lorem ipsum dolorsit amet"/>
				  </div>
			  </div>
			  <div class="tabs-data-content">
				<h2>{{item.title}}</h2>
				<div class="content-block">{{item.description}}</div>
				<a class="button-gray" href="javascript:void(0)">Content Button</a>
				<div class="next-steps-block">
					<a class="button-next" href="javascript:void(0)" >Next Step {{index+1}}</a>
				</div>
			  </div>
		  </div>
	  </div>
  </div>
</div>
</div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BButton, BForm, BFormInput, BFormGroup, BCard, BLink, BCardTitle, BCardText, BInputGroup, BInputGroupAppend, BFormCheckbox,
} from 'bootstrap-vue'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'

export default {
  components: {
    // BSV
    BButton,
    BForm,
    BFormInput,
    BFormGroup,
    BCard,
    BCardTitle,
    BLink,
    VuexyLogo,
    BCardText,
    BInputGroup,
    BInputGroupAppend,
    BFormCheckbox,
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      userEmail: '',
      password: '',
      status: '',
      // validation rules
      required,
      email,
      multistep: []
    }
  },
  created() {
    this.$http.get('/api/auth/get-data').then(res => { this.multistep = res.data.multiStep
    console.log(this.multistep)
    })
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    imgUrl() {
      
        return require('@/assets/images/pages/icon.svg')
        
    },
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
@import url('https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&display=swap');
.tabs-icon, .tabs-icon img, .tabs-text{ -webkit-transition:all 0.4s ease-in-out; -moz-transition:all 0.4s ease-in-out; -o-transition:all 0.4s ease-in-out; transition:all 0.4s ease-in-out;}

.multisteps{  font-family: 'Rubik', sans-serif;}
.multisteps{ width:100%; max-width:989px; margin:auto; border:2px solid #1570FF; border-radius:8px; font-size:16px; line-height:24px;}
.multisteps img{ max-width:100%;}
.multi-tabs{ background:rgba(21,112,255,0.1); padding:24px 0; margin:0; border-radius:8px;}
.inline-list{ list-style:none; padding:0 20px; text-align:center;}
.tab-link{ display:inline-block;}
.tabs-icon{ width:36px; height:36px; display:block; margin:auto; background:#999; border-radius:58.3333px; line-height:25px; padding:5px;}
.tabs-text{ color:#000; font-size:12px; line-height:18px; display:block; width:97px; margin-top:14.5px; letter-spacing:0.6px;}
.tab-link:hover .tabs-icon{ background:#1570FF;}
.tab-link:hover .tabs-text{ color:#1570FF;}
.tab-link.active .tabs-icon{ background:#1570FF; transform:scale(1.28);}
.tab-link.active .tabs-icon img{ transform:scale(0.746);}
.tab-link.active .tabs-text{ color:#1570FF;}
.multi-tabs-data{ padding:35px;}
.row-tabs-steps{}
.tabs-data-image{ width:50%;}
.tabs-data-content{ width:49%; padding:0 20px;}
.block-image{ max-width:415px; border-radius:4px; overflow:hidden;}
.tabs-data-content h2{ font-size:32px; font-weight:500; line-height:42px; margin:0 0 20px; color:#333;}
.content-block{ margin:0 0 20px; color:#666; margin:0 0 20px;}
.button-gray{ display:inline-block; font-weight:500; background:#666; color:#fff; border-radius:4px; padding:10px 15px;}
.button-gray:hover{ background:#1570FF; color:#fff;}
.next-steps-block{ padding-top:59px; text-align:right;}
.button-next{ display:inline-block; font-weight:500; background:#1570FF; color:#fff; border-radius:4px; border-radius:4px; padding:10px 15px; text-align:center;}
.button-next:hover{ background:#666; color:#fff;}

/*Responsive*/
/*IPHONE*/
@media (max-width:767px) {
.inline-list{ padding-bottom:25px;}	
.multi-tabs{ justify-content:center!important;}
.multi-tabs-data{ text-align:center;}
.multi-tabs-data{ padding:30px 20px;}
.tabs-data-image{ width:100%;}
.tabs-data-content{ width:100%; padding:20px 0 0;}
.next-steps-block{ text-align:center; padding-top:35px;}
.tabs-data-content h2{ font-size:26px; line-height:36px;}
.block-image{ margin:auto;}	
}

/*TABLET LAYOUT*/
@media only screen and (min-width: 768px) and (max-width: 1024px) {
.multi-tabs{ justify-content:center!important;}
}

</style>
