export const useFormat = () => {
  const testTypeFormat = computed(() => (testType: number) => {
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
  });
  
  const dateFormat = computed(() => (date: string) => {
    if (date) {
      const tmpDate = new Date(date);
      return tmpDate.toLocaleDateString("ja-JP", {
        month: "short",
        day: "numeric",
      });
    }
  });
  
  return { testTypeFormat, dateFormat };
};
