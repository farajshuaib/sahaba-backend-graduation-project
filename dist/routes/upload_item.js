"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = __importDefault(require("express"));
const upload_item_1 = require("../controllers/upload_item");
const router = express_1.default.Router();
router.post("/upload-item", upload_item_1.upload_image, upload_item_1.upload_item);
exports.default = router;
//# sourceMappingURL=upload_item.js.map