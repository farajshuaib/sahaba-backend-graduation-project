import express from "express";
import { authenticateSchema } from "../middlewares/validations";

import { authenticate } from "../controllers/users";

const router = express.Router();

router.get("/connect-wallet", authenticate);


export default router;
