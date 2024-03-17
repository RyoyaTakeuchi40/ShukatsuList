<template>
  <v-card>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-text-field
        v-model="name"
        :counter="10"
        :rules="nameRules"
        label="Name"
        required
      ></v-text-field>

      <v-text-field
        v-model="email"
        :rules="emailRules"
        label="E-mail"
        required
      ></v-text-field>


      <v-checkbox
        v-model="checkbox"
        :rules="[(v) => !!v || 'You must agree to continue!']"
        label="Do you agree?"
        required
      ></v-checkbox>

      <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit">
        Validate
      </v-btn>
    </v-form>
  </v-card>
</template>

<script setup lang="ts">
const valid = ref(true);
const name = ref("");
const nameRules = [
  (v: string) => !!v || "Name is required",
  (v: string) =>
    (v && v.length <= 10) || "Name must be less than 10 characters",
];
const email = ref("");
const emailRules = [
  (v: string) => !!v || "E-mail is required",
  (v: string) => /.+@.+\..+/.test(v) || "E-mail must be valid",
];
const select = ref<string | null>(null);
const items = ["Item 1", "Item 2", "Item 3", "Item 4"];
const checkbox = ref(false);

const submit = () => {
  console.log("submit");
};
</script>
