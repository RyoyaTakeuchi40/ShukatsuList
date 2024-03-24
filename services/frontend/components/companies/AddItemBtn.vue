<template>
  <v-btn @click="sheet = true" text="企業情報を追加する" />

  <v-bottom-sheet v-model="sheet">
    <v-card rounded height="75vh" class="pa-6 pb-12">
      <v-form v-model="valid">
        <v-card-text>
          <v-text-field
            v-model="item.name"
            label="会社名 *"
            :error-messages="errors.name"
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
const errors = ref({
  name: [],
});

const addItem = async () => {
  emits("overlayStart");
  await useApiFetch("/api/companies", {
    method: "POST",
    body: item.value,
  })
    .then((res) => {
      const error = res.error.value;
      if (error) {
        if (error.data?.errors) {
          errors.value = error.data.errors;
          console.log("422", errors.value);
        } else {
          console.log("error", error.data);
        }
      } else {
        emits("needRefresh");
        sheet.value = false;
      }
    })
    .catch(({ error }) => {
      console.log("exceptional...", error.value);
    });
};
</script>

<style scoped></style>
