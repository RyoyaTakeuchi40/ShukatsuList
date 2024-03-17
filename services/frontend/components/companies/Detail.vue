<template>
  <v-card>
    <v-card-title>
      <v-text-field
        v-model="item.name"
        :rules="[(v) => !!v || '会社名は必須項目です']"
        required
        variant="plain"
        hide-details="auto"
        class="font-weight-bold"
      />
    </v-card-title>
    <v-form>
      <v-card-text>
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
        <v-btn icon="mdi-close" @click="navigateTo('/companies')" />
        <v-spacer />
        <v-toolbar-items>
          <v-btn
            color="primary"
            text="編集"
            variant="tonal"
            @click="emits('editBtnClicked')"
          />
        </v-toolbar-items>
      </v-footer>
    </v-form>
  </v-card>
</template>

<script setup lang="ts">
const props = defineProps<{
  item: object;
}>();

const emits = defineEmits<{
  (e: "editBtnClicked"): void;
}>();

const selectTestType = ref([0, 1, 2, 3, 4, 5]);
</script>

<style scoped></style>
