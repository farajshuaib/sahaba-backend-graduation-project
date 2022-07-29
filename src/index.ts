import express, { Express } from "express";
import dotenv from "dotenv";
import prisma from "./services/prisma";
import cookieParser from "cookie-parser";
import bodyParser from "body-parser";
import cors from "cors"

import { useRoutes } from "./routes";
import useHeader from "./middlewares/header";

const app: Express = express();

// initialize configuration
dotenv.config();
app.use(express.static("public"));
app.use(express.json());
app.use(cookieParser());
app.use(cors());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(useHeader);

// setup db connection
async function main() {
  app.use(useRoutes());
}
main()
  .catch((e) => {
    console.log("something went wrong while connection to DB", e);
    process.exit(1)
  })
  .finally(async () => {
    await prisma.$disconnect();
  });

main();
// define a route handler for the default home page

// start the Express server
app.listen(process.env.PORT || 8000, () => {
  console.log(`server started at http://localhost:${process.env.PORT || 8000}`);
});
