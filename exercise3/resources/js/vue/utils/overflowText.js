const overflowText = (text, limit, ellipsisChars="...") => {
  if (limit && Number(limit)) {
    if (text.length > limit) {
      return `${text.substr(0, limit)}${ellipsisChars}`;
    } else {
      return text;
    }
  } else {
    console.warn(`invalid limit: ${limit}`);
    return text;
  }
};

export default overflowText;