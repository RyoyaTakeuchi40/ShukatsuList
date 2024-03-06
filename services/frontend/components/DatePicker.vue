<template>
  <v-menu v-model="isOpen" :close-on-content-click="false">
    <template v-slot:activator="{ props: menu }">
      <v-text-field
        v-model="props.date"
        label="日付"
        append-inner-icon="mdi-calendar"
        readonly
        v-bind="menu"
      />
    </template>
    <v-date-picker
      v-model="dateForPicker"
      @update:model-value="changeDate"
      hide-header
    />
  </v-menu>
</template>

<script setup lang="ts">
const props = defineProps<{
  date: string;
}>();

const emits = defineEmits<{
  (e: "setDate", v: string): void;
}>();
const isOpen = ref(false);
const dateForPicker = ref(new Date(props.date));

const changeDate = () => {
  isOpen.value = false;
  const formattedDate = dateForPicker.value
    .toLocaleDateString("ja-JP", {
      year: "numeric",
      month: "2-digit",
      day: "2-digit",
    })
    .split("/")
    .join("-");
  emits("setDate", formattedDate);
};
</script>
