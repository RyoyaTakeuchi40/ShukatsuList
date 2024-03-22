<template>
  <v-card>
    <v-data-table
      :headers="headers"
      :items="items"
      hover
      hide-no-data
      fixed-header
      items-per-page="-1"
      item-value="id"
      class="my-table text-no-wrap"
    >
      <template v-slot:top>
        <v-toolbar>
          <v-toolbar-title>選考</v-toolbar-title>
          <v-spacer />
          <v-select
            v-model="select"
            :items="[
              'お気に入り',
              '選考前',
              '選考中',
              '内定',
              'お祈り',
              '辞退',
              '全て',
            ]"
            variant="underlined"
            class="px-2"
          />
          <CompaniesAddItemBtn
            @overlay-start="emits('overlayStart')"
            @need-refresh="emits('needRefresh')"
          />
        </v-toolbar>
      </template>

      <template v-slot:item="{ item }">
        <tr @click="clickRow(item.id)">
          <template v-for="header in headers">
            <td v-if="header.key === 'result'">
              <CompaniesStatusChip :result="item.result" />
            </td>

            <td v-else-if="header.key === 'name'">
              {{ item.name }}
              <v-btn
                v-if="item.url"
                icon="mdi-open-in-new"
                size="small"
                variant="plain"
                @click.stop="clickLink(item.url)"
              />
            </td>

            <td v-else-if="header.key === 'favorite'">
              <v-checkbox-btn
                :model-value="item.favorite === 1"
                @click.stop="clickFavorite(item.id, item.favorite)"
                true-icon="mdi-star"
                false-icon="mdi-star-outline"
              />
            </td>

            <td v-else-if="header.key === 'login'">
              {{ item[header.key] }}
            </td>

            <td
              v-else-if="header.key === 'test'"
              class="d-flex justify-between align-center"
              :class="tdBgColor(header.key)"
            >
              <div>{{ dateFormat(item.test.date) }}　</div>
              <div>{{ testTypeFormat(item.test.type) }}</div>
            </td>

            <td
              v-else-if="typeof header.key === 'number'"
              :class="tdBgColor(header.key)"
            >
              <template v-if="item.interviews[header.key]">
                {{ dateFormat(item.interviews[header.key].date) }}
              </template>
            </td>

            <td v-else-if="header.key === 'delete'">
              <v-dialog transition="dialog-bottom-transition" width="auto">
                <template v-slot:activator="{ props }">
                  <v-btn
                    v-bind="props"
                    icon="mdi-delete"
                    size="small"
                    variant="plain"
                  />
                </template>
                <template v-slot:default="{ isActive }">
                  <v-card>
                    <v-card-text>
                      「{{ item.name }}」の情報を本当に削除しますか？
                    </v-card-text>
                    <v-card-actions class="d-flex justify-end">
                      <v-btn
                        text="いいえ"
                        color="warning"
                        @click="isActive.value = false"
                      />
                      <v-btn
                        text="はい"
                        color="primary"
                        @click="clickDelete(item.id)"
                      />
                    </v-card-actions>
                  </v-card>
                </template>
              </v-dialog>
            </td>

            <td v-else :class="tdBgColor(header.key)">
              {{ dateFormat(item[header.key].date) }}
            </td>
          </template>
        </tr>
      </template>
    </v-data-table>
  </v-card>
</template>

<script setup lang="ts">
const props = defineProps<{
  items: Array<any>;
  headers: Array<any>;
}>();
const emits = defineEmits<{
  (e: "overlayStart"): void;
  (e: "needRefresh"): void;
}>();

const { testTypeFormat, dateFormat } = useFormat();
const select = ref("選考中");

const filterItems = (result: number, favorite: number) => {};
const clickRow = (id: number) => {
  navigateTo(`/companies/${id}`);
};
const clickLink = (url: string) => {
  window.open(`${url}`, "_blanck");
};
const clickFavorite = async (id: number, favorite: number) => {
  emits("overlayStart");
  await useApiFetch(`/api/companies/${id}/favorite`, {
    method: "POST",
    body: { favorite: favorite ? 0 : 1 },
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
    });
};
const clickDelete = async (id: number) => {
  emits("overlayStart");
  await useApiFetch(`/api/companies/${id}/destroy`, {
    method: "POST",
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
    });
};
const tdBgColor = (result: number) => {};
</script>

<style scoped>
.v-data-table >>> .v-data-table-footer {
  display: none;
}

/* ヘッダ（th）の固定 */
.my-table >>> th:nth-child(2) {
  position: sticky !important;
  position: -webkit-sticky !important;
  left: 0;
  z-index: 1;
  background-color: white;
  border-right: 1px solid grey;
}

/* 行（td）の固定 */
.my-table >>> td:nth-child(2) {
  position: sticky !important;
  position: -webkit-sticky !important;
  left: 0;
  z-index: 1;
  background-color: white;
  border-right: 1px solid grey;
}
</style>
