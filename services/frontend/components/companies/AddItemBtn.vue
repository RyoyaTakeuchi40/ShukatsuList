<template>
  <v-btn @click="sheet = true" text="企業情報を追加する" />

  <v-bottom-sheet v-model="sheet">
    <v-card rounded height="75vh" class="pa-6 pb-12">
      <v-form v-model="valid">
        <v-card-text>
          <v-text-field
            v-model="item.name"
            :rules="[(v) => !!v || '会社名は必須項目です']"
            label="会社名 *"
            required
            variant="outlined"
            density="comfortable"
            hide-details="auto"
            class="my-2"
          />

          <v-text-field
            v-model="item.url"
            label="URL"
            variant="outlined"
            density="comfortable"
            hide-details
            class="mb-2"
          />

          <v-text-field
            v-model="item.login"
            label="ログインID"
            variant="outlined"
            density="comfortable"
            hide-details
            class="my-2"
          />

          <v-text-field
            v-model="item.note"
            label="メモ"
            variant="outlined"
            density="comfortable"
            hide-details
            class="my-2"
          />

          <CompaniesDetailCard title="ES" :value="item.es" />
          <CompaniesDetailCard title="テスト" :value="item.test" />
          <CompaniesDetailCard title="GD" :value="item.gd" />
          <template v-for="(interview, i) in item.interviews">
            <CompaniesDetailCard :title="`${i + 1}次面接`" :value="interview" />
          </template>
        </v-card-text>
        <v-footer app density="comfortable" class="bg-grey-lighten-2">
          <v-btn icon="mdi-close" @click="sheet = false" />
          <v-spacer />
          <v-toolbar-items>
            <v-btn
              color="primary"
              text="追加"
              variant="tonal"
              :disabled="!valid"
              @click="addItem"
            />
          </v-toolbar-items>
        </v-footer>
      </v-form>
    </v-card>
  </v-bottom-sheet>
</template>

<script setup lang="ts">
const emits = defineEmits<{
  (e: "overlayStart"): void;
  (e: "needRefresh"): void;
}>();

const sheet = ref(false);
const valid = ref(true);
const item = ref({
  name: "",
  url: "",
  login: "",
  note: "",
  es: {
    date: "",
    note: "",
  },
  test: {
    date: "",
    type: 0,
    note: "",
  },
  gd: {
    date: "",
    note: "",
  },
  interviews: [
    {
      date: "",
      note: "",
    },
  ],
});
const selectTestType = ref([0, 1, 2, 3, 4, 5]);

const addItem = async () => {
  emits("overlayStart");
  await useApiFetch("/api/companies", {
    method: "POST",
    body: item.value,
  })
    .then((res) => {
      const error = res.error.value;
      if (error) {
        console.log("error", error);
      } else {
        emits("needRefresh");
      }
    })
    .catch(({ error }) => {
      console.log("exceptional...", error.value);
    })
    .finally(() => {
      sheet.value = false;
    });
};
</script>

<style scoped></style>
