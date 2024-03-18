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
        <tr @click="clickRow(item.id)" class="bg-red-lighten-4">
          <template v-for="header in headers">
            <td v-if="header.key === 'result'">
              <v-chip :color="chipColor(item.result)" size="small">
                {{ chipLabel(item.result) }}
              </v-chip>
            </td>

            <td v-else-if="header.key === 'name'" class="bg-red-lighten-4">
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
              :class="tdBgColor(header.key, item)"
            >
              <div>{{ dateFormat(item.test) }}　</div>
              <div>{{ testTypeFormat(item.test_type) }}</div>
            </td>

            <td v-else-if="typeof header.key === 'number'">
              <template v-if="item.interviews[header.key]">
                {{ dateFormat(item.interviews[header.key].interview) }}
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

            <td v-else :class="tdBgColor(header.key, item)">
              {{ dateFormat(item[header.key]) }}
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
  await useFetch(`/api/companies/${id}/favorite`, {
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
  await useFetch(`/api/companies/${id}/destroy`, {
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

const chipLabel = (result: number) => {
  if (result === 1) {
    return "選考中";
  } else if (result === 2) {
    return "内　定";
  } else if (result === 3) {
    return "お祈り";
  } else if (result === 4) {
    return "辞　退";
  } else {
    return "選考前";
  }
};
const chipColor = (result: number) => {
  if (result === 1) {
    return "primary";
  } else if (result === 2) {
    return "success";
  } else if (result === 3) {
    return "error";
  } else if (result === 4) {
    return "";
  } else {
    return "secondary";
  }
};
const testTypeFormat = (testType: number) => {
  if (testType === 1) {
    return "SPI";
  } else if (testType === 2) {
    return "玉手箱";
  } else if (testType === 3) {
    return "GAB";
  } else if (testType === 4) {
    return "CAB";
  } else if (testType === 5) {
    return "TG-WEB";
  } else if (testType === 6) {
    return "ENG";
  } else if (testType === 7) {
    return "CUBIC";
  } else if (testType === 8) {
    return "GPS";
  } else if (testType === 9) {
    return "技術テスト";
  } else if (testType === 10) {
    return "その他";
  } else {
    return " ";
  }
};
const dateFormat = (date: string) => {
  if (date) {
    const tmpDate = new Date(date);
    return tmpDate.toLocaleDateString("ja-JP", {
      month: "short",
      day: "numeric",
    });
  }
};
const trBgColor = (result: number) => {};
const tdBgColor_ = (result: number) => {};
const tdBgColor = (key: string, item: object) => {};
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
  border-right: 1px solid grey;
}
</style>
