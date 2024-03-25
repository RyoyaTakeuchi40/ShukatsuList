<template>
  <v-card>
    <v-card-title class="d-flex">
      <v-col cols="8">
        <v-text-field
          v-model="item.name"
          :error-messages="errors.name"
          required
          variant="plain"
          hide-details="auto"
          :prepend-inner-icon="item.favorite ? 'mdi-star' : 'mdi-star-outline'"
          @click:prepend-inner="
            item.favorite ? (item.favorite = 0) : (item.favorite = 1)
          "
          class="font-weight-bold"
        />
      </v-col>
      <v-spacer />
      <v-select
        v-model="item.result"
        :items="[0, 1, 2, 3, 4]"
        variant="plain"
        hide-details
        class="align-center"
      >
        <template v-slot:item="{ props, item }">
          <v-list-item v-bind="props" title="">
            <CompaniesStatusChip :result="item.raw" size="default" />
          </v-list-item>
        </template>
        <template v-slot:chip>
          <CompaniesStatusChip :result="item.result" size="default" />
        </template>
      </v-select>
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
        <CompaniesDetailCard title="ES" :value="item.es" />
        <CompaniesDetailCard title="テスト" :value="item.test" />
        <CompaniesDetailCard title="GD" :value="item.gd" />
        <template v-for="(interview, i) in item.interviews">
          <CompaniesDetailCard :title="`${i + 1}次面接`" :value="interview" />
        </template>
        <v-sheet class="d-flex">
          <v-btn text="面接を削除する" @click="checkContent" />

          <v-dialog
            v-model="dialog"
            transition="dialog-bottom-transition"
            width="auto"
          >
            <v-card>
              <v-card-text>
                {{ item.interviews.length }}次面接の情報を本当に削除しますか？
              </v-card-text>
              <v-card-actions class="d-flex justify-end">
                <v-btn text="いいえ" color="warning" @click="dialog = false" />
                <v-btn
                  text="はい"
                  color="primary"
                  @click="(dialog = false), emits('deleteInterview')"
                />
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-spacer />
          <v-btn text="面接を追加する" @click="emits('addInterview')" />
        </v-sheet>
      </v-card-text>

      <v-footer app density="comfortable" class="bg-grey-lighten-2">
        <v-btn
          icon="mdi-arrow-left"
          @click="emits('overlayStart'), navigateTo('/companies')"
        />
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
  errors: object;
}>();
const emits = defineEmits<{
  (e: "overlayStart"): void;
  (e: "editBtnClicked"): void;
  (e: "addInterview"): void;
  (e: "deleteInterview"): void;
}>();

const dialog = ref(false);

const checkContent = () => {
  const lastIntervivew = props.item.interviews.at(-1);
  if (lastIntervivew.date || lastIntervivew.note || lastIntervivew.result) {
    dialog.value = true;
  } else {
    emits("deleteInterview");
  }
};
</script>

<style scoped></style>
