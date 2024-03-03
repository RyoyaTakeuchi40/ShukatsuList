<template>
  <v-btn text="戻る" @click="navigateTo('/')" class="my-2" />
  <v-card class="px-2 py-4">
    <v-form v-model="valid">
      <v-text-field
        v-model="item.name"
        :rules="[(v) => !!v || '会社名は必須項目です']"
        label="会社名"
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
        class="my-2"
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

      <v-card>
        <p class="ma-2 text-xl">ES</p>
        <v-text-field
          v-model="item.es"
          label="日付"
          type="date"
          variant="outlined"
          density="comfortable"
          hide-details
          class="w-50 ml-4 mr-2 my-2"
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

      <v-card>
        <p class="ma-2 text-xl">テスト</p>
        <v-text-field
          v-model="item.test"
          label="日付"
          type="date"
          variant="outlined"
          density="comfortable"
          hide-details
          class="w-50 mr-4 ml-4 my-2 d-inline-block"
        />
        <v-select
          v-model="item.testType"
          :items="selectItems"
          label="種類"
          variant="outlined"
          density="comfortable"
          hide-details
          class="w-25 ml-4 mr-2 my-2 d-inline-block"
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

      <v-card>
        <p class="ma-2 text-xl">GD</p>
        <v-text-field
          v-model="item.gd"
          label="日付"
          type="date"
          variant="outlined"
          density="comfortable"
          hide-details
          class="w-50 ml-4 mr-2 my-2"
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
        <v-card>
          <p class="ma-2 text-xl">{{ i + 1 }}次面接</p>
          <v-text-field
            v-model="item.gd"
            label="日付"
            type="date"
            variant="outlined"
            density="comfortable"
            hide-details
            class="w-50 ml-4 mr-2 my-2"
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
      <div class="d-flex justify-end">
        <v-btn
          text="追加"
          :disabled="!valid"
          color="primary"
          @click="addItem"
          class="mt-4"
        />
      </div>
    </v-form>
  </v-card>
</template>

<script setup lang="ts">
const setDate = (key: string | number, val: string) => {
  if (typeof key == "string") {
    item.value[key] = val;
  } else {
    item.value.interviews[key].interview = val;
  }
};

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

const selectItems = ref([0, 1, 2, 3, 4, 5]);

const addItem = async () => {
  const { data, error } = await useFetch("/api/companies/companies", {
    method: "POST",
    body: item.value,
  });
  if (error.value) {
    console.log("error", error.value);
  } else {
    console.log("success", data.value);
    navigateTo("/");
  }
};
</script>
