<template>
  <v-toolbar density="compact" class="mb-4 bg-transparent">
    <v-toolbar-items>
      <v-btn
        v-for="i in 2"
        :text="i === 1 ? '1日以下' : '３日以下'"
        :ripple="false"
        size="small"
        :class="
          tdBgColor(
            0,
            String(
              new Date(
                today.getFullYear(),
                today.getMonth(),
                today.getDate() + i
              )
            )
          )
        "
      />
    </v-toolbar-items>
    <v-spacer />
    <v-toolbar-items>
      <v-btn
        v-for="i in 2"
        :text="resultFormat(i)"
        :ripple="false"
        size="small"
        :class="tdBgColor(i, undefined)"
      />
    </v-toolbar-items>
  </v-toolbar>

  <v-card>
    <v-data-table
      :headers="headers"
      :items="filterItems"
      hover
      hide-no-data
      fixed-header
      items-per-page="-1"
      item-value="id"
      class="my-table text-no-wrap"
    >
      <template v-slot:top>
        <v-toolbar class="pt-2">
          <v-spacer />
          <v-spacer />
          <v-spacer />
          <v-select
            v-model="select"
            :items="['選考前', '選考中', '内定', 'お祈り', '辞退']"
            label="絞り込み"
            chips
            multiple
            clearable
            variant="underlined"
            class="px-2"
          />
        </v-toolbar>
      </template>

      <template v-slot:header.favorite>
        <v-checkbox-btn
          v-model="favorite"
          true-icon="mdi-star"
          false-icon="mdi-star-outline"
        />
      </template>

      <template v-slot:item="{ item }">
        <tr @click="clickRow(item.id)">
          <template v-for="header in headers">
            <td v-if="header.key === 'result'" class="px-2">
              <CompaniesStatusChip :result="item.result" />
            </td>

            <td v-else-if="header.key === 'name'" class="px-2">
              {{ item.name }}
              <v-icon
                v-if="item.url"
                icon="mdi-open-in-new"
                size="small"
                color="info"
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

            <td
              v-else-if="typeof header.key === 'number'"
              :class="
                tdBgColor(
                  item.interviews[header.key]?.result,
                  item.interviews[header.key]?.date
                )
              "
            >
              {{ dateFormat(item.interviews[header.key]?.date) }}
            </td>

            <td
              v-else
              :class="tdBgColor(item[header.key].result, item[header.key].date)"
            >
              {{ dateFormat(item[header.key].date) }}
            </td>
          </template>
        </tr>
      </template>

      <template v-slot:bottom>
        <CompaniesAddItemBtn
          @overlayStart="emits('needRefresh')"
          @needRefresh="emits('needRefresh')"
        />
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

const { dateFormat, resultFormat } = useFormat();
const favorite = ref(false);
const select = ref(["選考中", "選考前"]);
const today = ref(new Date());

const clickRow = (id: number) => {
  emits("overlayStart");
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

const filterItems = computed(() => {
  const filtered = ref([]);
  if (select.value.includes("選考中")) {
    filtered.value.push(...props.items.filter((item) => item.result === 1));
  }
  if (select.value.includes("選考前")) {
    filtered.value.push(...props.items.filter((item) => item.result === 0));
  }
  if (select.value.includes("内定")) {
    filtered.value.push(...props.items.filter((item) => item.result === 2));
  }
  if (select.value.includes("お祈り")) {
    filtered.value.push(...props.items.filter((item) => item.result === 3));
  }
  if (select.value.includes("辞退")) {
    filtered.value.push(...props.items.filter((item) => item.result === 4));
  }

  if (select.value.length === 0) {
    filtered.value = props.items;
  }
  if (favorite.value) {
    return filtered.value.filter((item) => item.favorite === 1);
  }
  return filtered.value;
});
const tdBgColor = computed(() => (result: number, date: string | undefined) => {
  if (result === 1) {
    return "bg-blue-lighten-4";
  } else if (result === 2) {
    return "bg-blue-lighten-5";
  } else if (result === 3) {
    return "bg-grey-lighten-2";
  } else if (result === 4) {
    return "bg-brown-lighten-3";
  } else {
    if (!!date) {
      const loadDate = new Date(date);
      const diffDays = Math.floor((today.value - loadDate) / 86400000);
      if (diffDays > -2) {
        return "bg-red-lighten-4";
      } else if (diffDays > -4) {
        return "bg-yellow-lighten-4";
      }
    } else {
      return "";
    }
  }
});
</script>

<style scoped>
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
