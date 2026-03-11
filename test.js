const supabase = require("./config/supabase");

async function probar() {

  const { data, error } = await supabase
    .from("users")
    .select("*");

  if (error) {
    console.log("Error:", error);
  } else {
    console.log("Conectado a Supabase");
    console.log(data);
  }

}

probar();