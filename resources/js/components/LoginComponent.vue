<template>
  <div><v-app id="inspire">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Login form</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <!-- <v-btn :href="source" icon large target="_blank" v-on="on"> -->
                      <!-- <v-icon large>code</v-icon> -->
                    <!-- </v-btn> -->
                  </template>
                  <span>Source</span>
                </v-tooltip>
                <v-tooltip right>
                  <template v-slot:activator="{ on }">
                    <!-- <v-btn icon large href="https://codepen.io/johnjleider/pen/wyYVVj" target="_blank" v-on="on"> -->
                      <!-- <v-icon large>mdi-codepen</v-icon> -->
                    </v-btn>
                  </template>
                  <span>Codepen</span>
                </v-tooltip>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field prepend-icon="person" name="login" label="Login" type="text" v-model="form.username"></v-text-field>
                  <v-text-field id="password" prepend-icon="lock" name="password" label="Password" type="password" v-model="form.password"></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary"
                @click="loginHandler"
                 type="submit"
                >Login</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app></div>
</template>

<script>
  import auth from '../service/Auth'
  export default {
    name: 'LoginComponent',
    data () {
      return {
        form: {
          username: '',
          password: ''
        },
      }
    },
    methods: {
      async loginHandler(){
        try {
          await auth.authenticate(this.form)
          this.$router.push({path: '/home/beranda'});
        } catch (err) {
          console.log('gak masuk')
        }
      }
    } 
  }
</script>