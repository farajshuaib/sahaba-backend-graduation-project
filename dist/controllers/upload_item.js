"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.upload_item = exports.upload_image = void 0;
const multer_1 = __importDefault(require("multer"));
const ipfs_api_1 = __importDefault(require("ipfs-api"));
//Connceting to the ipfs network via infura gateway
const ipfs = (0, ipfs_api_1.default)("ipfs.infura.io", "5001", { protocol: "https" });
const multer_storage = multer_1.default.memoryStorage();
const multer_filter = (req, file, cb) => {
    if (file.mimetype.startsWith("image")) {
        cb(null, true);
    }
    else {
        cb("error", false);
    }
};
const upload = (0, multer_1.default)({
    storage: multer_storage,
    fileFilter: multer_filter,
});
// storing the process image in the buffer storage
exports.upload_image = upload.single("photo");
const upload_item = (req, res) => __awaiter(void 0, void 0, void 0, function* () {
    const file = req.file;
    if (!file) {
        res.status(400).json({ message: "File not found" });
        return;
    }
    try {
        const result = yield ipfs.add(file.buffer);
        console.log("result", result[0]);
        const hash = result[0].hash; // should saved to the db to return it from ipfs.get() in the future
        res.status(200).json({
            message: "success",
            data: { path: `https://ipfs.infura.io/ipfs/${result[0].path}` },
        });
    }
    catch (error) {
        console.log("ipfs image upload error: ", error);
        res.status(500).send({ message: "upload failed", error: error });
    }
});
exports.upload_item = upload_item;
//# sourceMappingURL=upload_item.js.map