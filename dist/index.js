"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = __importDefault(require("express"));
const dotenv_1 = __importDefault(require("dotenv"));
const path_1 = __importDefault(require("path"));
const routes_1 = require("./routes");
const app = (0, express_1.default)();
// initialize configuration
dotenv_1.default.config();
app.use(express_1.default.static("public"));
app.use(express_1.default.json());
// Configure Express to use EJS
app.set("views", path_1.default.join(__dirname, "views"));
app.set("view engine", "ejs");
// define a route handler for the default home page
app.use(routes_1.upload_item);
app.get("/", (req, res) => res.send("Hello world!"));
// start the Express server
app.listen(process.env.PORT || 8080, () => {
    console.log(`server started at http://localhost:${process.env.PORT || 8080}`);
});
//# sourceMappingURL=index.js.map