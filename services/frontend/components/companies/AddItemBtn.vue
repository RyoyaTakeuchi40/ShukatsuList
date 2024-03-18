<template>
  <v-btn @click="sheet = true" text="追加" />

  <v-bottom-sheet v-model="sheet">
    <v-card rounded height="75vh" class="pa-4">
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

          <v-card title="ES" class="my-2">
            <v-text-field
              v-model="item.es"
              type="date"
              variant="outlined"
              density="comfortable"
              hide-details
              class="w-50 ml-4 mr-2 mb-2"
            />
            <v-text-field
              v-model="item.esNote"
              label="メモ"
              variant="outlined"
              density="comfortable"
              hide-details
              class="ml-4 mr-2 my-2"
            />
          </v-card>

          <v-card title="テスト" class="my-2">
            <v-text-field
              v-model="item.test"
              type="date"
              variant="outlined"
              density="comfortable"
              hide-details
              class="w-50 mr-4 ml-4 mbd-2 d-inline-block"
            />
            <v-select
              v-model="item.testType"
              :items="selectTestType"
              label="種類"
              variant="outlined"
              density="comfortable"
              hide-details
              class="w-25 ml-4 mr-2 mb-2 d-inline-block"
            />
            <v-text-field
              v-model="item.testNote"
              label="メモ"
              variant="outlined"
              density="comfortable"
              hide-details
              class="ml-4 mr-2 my-2"
            />
          </v-card>

          <v-card title="GD" class="my-2">
            <v-text-field
              v-model="item.gd"
              type="date"
              variant="outlined"
              density="comfortable"
              hide-details
              class="w-50 ml-4 mr-2 mb-2"
            />
            <v-text-field
              v-model="item.gdNote"
              label="メモ"
              variant="outlined"
              density="comfortable"
              hide-details
              class="ml-4 mr-2 my-2"
            />
          </v-card>

          <template v-for="(interview, i) in item.interviews">
            <v-card :title="`${i + 1}次面接`" class="my-2">
              <v-text-field
                v-model="interview.interview"
                type="date"
                variant="outlined"
                density="comfortable"
                hide-details
                class="w-50 ml-4 mr-2 mb-2"
              />
              <v-text-field
                v-model="interview.note"
                label="メモ"
                variant="outlined"
                density="comfortable"
                hide-details
                class="ml-4 mr-2 my-2"
              />
            </v-card>
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
  es: "",
  esNote: "",
  test: "",
  testType: 0,
  testNote: "",
  gd: "",
  gdNote: "",
  interviews: [
    {
      interview: "",
      note: "",
    },
  ],
});
const selectTestType = ref([0, 1, 2, 3, 4, 5]);

const addItem = async () => {
  emits("overlayStart");
  await useFetch("/api/companies", {
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
