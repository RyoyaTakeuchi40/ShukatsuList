<template>
  <v-card>
    <v-data-table
      :headers="props.headers"
      :items="props.items"
      :hover="true"
      :hide-no-data="true"
      @click:row="clickRow"
      item-value="id"
      class="text-no-wrap"
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
          />
        </v-toolbar>
      </template>

      <template v-slot:item="{ item }">
        <tr>
          <template v-for="header in headers">
            <td v-if="header.key === 'result'">
              <v-chip :color="chipColor(item.result)" size="small">
                {{ chipLabel(item.result) }}
              </v-chip>
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
                        @click.stop="clickDelete(item.id)"
                        @click="isActive.value = false"
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

const select = ref("選考中");

const filterItems = (result: number, favorite: number) => {
  if (select.value.includes("選考前")) {
    return result === 0;
  }
  if (select.value.includes("選考中")) {
    return result === 1;
  }
  if (select.value.includes("内定")) {
    return result === 2;
  }
  if (select.value.includes("お祈り")) {
    return result === 3;
  }
  if (select.value.includes("辞退")) {
    return result === 4;
  }
  if (select.value.includes("お気に入り")) {
    return favorite === 1;
  }
  return true;
};

const clickRow = (_: any, item: { item: { id: any } }) => {
  console.log("id:", item.item.id);
  // window.open(`/${id}`, '_blanck')
};
const clickFavorite = (id: number, favorite: number) => {
  console.log("Favorite:", id, favorite);
};
const clickLink = (url: string) => {
  console.log("URL:", url);
  window.open(`${url}`, "_blanck");
};
const clickDelete = (id: string) => {
  console.log("delete:", id);
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
const trBgColor = (result: number) => {
  if (result === 1) {
    return "bg-green-accent-1";
  } else if (result === 2) {
    return "bg-blue-accent-1";
  } else if (result === 3) {
    return "bg-red-accent-1";
  } else if (result === 4) {
    return "bg-grey-darken-1";
  } else {
    return "";
  }
};
const tdBgColor_ = (result: number) => {
  if (result === 1) {
    return "bg-grey-lighten-4";
  } else if (result === 2) {
    return "bg-grey-lighten-2";
  } else if (result === 3) {
    return "bg-grey-darken-2";
  } else if (result === 4) {
    return "bg-grey";
  } else {
    return "";
  }
};
const tdBgColor = (key: string, item: object) => {
  if (item.result === 1) {
    if (key === "es") {
      return tdBgColor_(item.check_es);
    } else if (key === "test") {
      return tdBgColor_(item.check_test);
    } else if (key === "gd") {
      return tdBgColor_(item.check_gd);
    } else if (key === "interview_1") {
      return tdBgColor_(item.check_1);
    } else if (key === "interview_2") {
      return tdBgColor_(item.check_2);
    } else if (key === "interview_3") {
      return tdBgColor_(item.check_3);
    }
  }
};
</script>

<style scoped></style>
