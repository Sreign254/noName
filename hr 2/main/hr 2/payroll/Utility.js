const date = `1 November 2020`;
const stringifyDate = (date) => {
  console.log(date);
  const option = { day: "numeric", month: "short", year: "numeric" };
  return new Date(Date.parse(date)).toLocaleDateString("en-GB", option);
};
