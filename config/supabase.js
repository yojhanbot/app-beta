const { createClient } = require("@supabase/supabase-js");

const supabaseUrl = "https://xhitjiybpdjnvfevxplw.supabase.co";
const supabaseKey = "sb_publishable_SZUKJrnYhs9R0Ez0f0v-YQ_2LESmSdn";

const supabase = createClient(supabaseUrl, supabaseKey);

module.exports = supabase;