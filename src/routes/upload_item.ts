import express from "express";

import { upload_item, upload_image } from "../controllers/upload_item";

const router = express.Router();

router.post("/upload-item", upload_image, upload_item);

export default router;
