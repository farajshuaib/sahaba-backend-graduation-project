// SPDX-License-Identifier: MIT
pragma solidity ^0.8.4;

import "@openzeppelin/contracts/token/ERC721/extensions/ERC721URIStorage.sol";
import "@openzeppelin/contracts/token/ERC721/extensions";

contract NFT is ERC721Full, ERC721Mintable {
    uint256 public tokenCount;

    constructor() ERC721("DApp NFT", "DAPP") {} // call the constructor of inherited contract

    // function mint(string memory _tokenURI) external returns (uint256) {
    //     tokenCount++;
    //     _safeMint(msg.sender, tokenCount);
    //     _setTokenURI(tokenCount, _tokenURI);
    //     return (tokenCount);
    // }

    function mintToken(
        address to,
        uint256 tokenId,
        string uri
    ) public {
        mint(to, tokenId);
        require(_exists(tokenId));
        _setTokenURI(tokenId, uri);
    }

    function burnToken(address owner, uint256 tokenId) public {
        _burn(owner, tokenId);
    }
}
