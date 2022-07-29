"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.useRoutes = void 0;
const express_1 = __importDefault(require("express"));
const product_1 = __importDefault(require("./product"));
const router = express_1.default.Router();
const useRoutes = () => {
    router.get("/", (req, res) => res
        .status(200)
        .json({ status: 200, message: "Welcome to sahaba NFT marketplace" }));
    router.use(product_1.default);
    return router;
};
exports.useRoutes = useRoutes;
//# sourceMappingURL=index.js.map