<template>
  <v-card class="my-4">
    <v-card-title class="d-flex align-center">
      <span class="w-50">{{ title }}</span>
      <v-spacer />
      <v-select
        v-if="typeof value.result !== 'undefined'"
        v-model="value.result"
        :items="resultItems"
        :item-title="resultFormat"
        return-object
        variant="underlined"
        density="compact"
      />
    </v-card-title>
    <v-text-field
      v-model="value.date"
      type="date"
      variant="outlined"
      density="comfortable"
      hide-details
      class="ml-4 mr-2 mb-2 d-inline-block"
    />
    <v-select
      v-if="typeof value.type !== 'undefined'"
      v-model="value.type"
      :items="testTypeItems"
      :item-title="testTypeTitle"
      return-object
      label="種類"
      variant="outlined"
      density="comfortable"
      hide-details
      class="ml-2 mr-2 mb-2 d-inline-block"
    />
    <v-text-field
      v-model="value.note"
      label="メモ"
      variant="outlined"
      density="comfortable"
      hide-details
      class="ml-4 mr-2 my-2"
    />
  </v-card>
</template>

<script setup lang="ts">
const props = defineProps<{
  title: string;
  value: {
    date: string;
    type?: number;
    note: string;
    result?: number;
  };
}>();

const { resultFormat, testTypeFormat } = useFormat();
const resultItems = ref(Array.from({ length: 5 }, (_, index) => index));
const testTypeItems = ref(Array.from({ length: 11 }, (_, index) => index));
const testTypeTitle = computed(() => (type: number) => {
  const title = testTypeFormat.value(type);
  return title ? title : "なし";
});
</script>
