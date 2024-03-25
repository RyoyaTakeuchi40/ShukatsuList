<template>
  <v-overlay v-model="props.overlay" class="align-center justify-center">
    <v-progress-circular
      color="primary"
      size="64"
      indeterminate
    ></v-progress-circular>
  </v-overlay>
</template>

<script setup lang="ts">
const props = defineProps<{
  overlay: boolean;
}>();
</script>
