import express, { Express } from "express";
import dotenv from "dotenv";
import path from "path";

import { upload_item } from "./routes";

const app: Express = express();

// initialize configuration
dotenv.config();
app.use(express.static("public"));
app.use(express.json());

// Configure Express to use EJS
app.set("views", path.join(__dirname, "views"));
app.set("view engine", "ejs");

// define a route handler for the default home page
app.use(upload_item);
app.get("/", (req, res) => res.send("Hello world!"));

// start the Express server
app.listen(process.env.PORT || 8080, () => {
  console.log(`server started at http://localhost:${process.env.PORT || 8080}`);
});
