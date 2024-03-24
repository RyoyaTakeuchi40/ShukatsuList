<template>
  <v-chip :color="chipColor" :size="size">
    {{ resultTitle(result) }}
  </v-chip>
</template>

<script setup lang="ts">
const { resultFormat } = useFormat();
const props = withDefaults(
  defineProps<{
    result: number;
    size?: string;
  }>(),
  {
    size: "small",
  }
);

const resultTitle = computed(() => (result: number) => {
  const title = resultFormat.value(result);
  return title === "通　過" ? "内　定" : title;
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
