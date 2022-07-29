import express from "express";

import { upload_item } from "../controllers/product";
import multerHandler from "../middlewares/multerHandler";

const router = express.Router();

router.post("/upload-item", multerHandler, upload_item);

export default router;
