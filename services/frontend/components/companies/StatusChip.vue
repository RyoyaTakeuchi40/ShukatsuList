<template>
  <v-chip :color="chipColor" :size="size">
    {{ chipLabel }}
  </v-chip>
</template>

<script setup lang="ts">
const props = withDefaults(
  defineProps<{
    result: number;
    size?: string;
  }>(),
  {
    size: "small",
  }
);

const chipLabel = computed(() => {
  if (props.result === 1) {
    return "選考中";
  } else if (props.result === 2) {
    return "内　定";
  } else if (props.result === 3) {
    return "お祈り";
  } else if (props.result === 4) {
    return "辞　退";
  } else {
    return "選考前";
  }
});

const chipColor = computed(() => {
  if (props.result === 1) {
    return "primary";
  } else if (props.result === 2) {
    return "success";
  } else if (props.result === 3) {
    return "error";
  } else if (props.result === 4) {
    return "";
  } else {
    return "secondary";
  }
});
</script>
